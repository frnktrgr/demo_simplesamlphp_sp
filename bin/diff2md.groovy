def procBranch = "git branch --show-current".execute()
procBranch.waitFor()
def branch = procBranch.in.text.trim()
println "in branch ${branch} ..."
def linkTo = { base, path ->
    return "[${path}](../../../blob/${branch}/${base}/${path})"
}
def diff2md = { from, to ->
    def output = ""
    def outputAdded = ""
    def outputRemoved = ""
    def procDiff = ['diff', '-u', '-r', '--exclude=README.md', '--exclude=volumes', from, to].execute()
    procDiff.waitFor()
    def diffOutput = procDiff.in.text
    def indiff = false
    diffOutput.eachLine { line ->
        if (line.startsWith('Only')) {
            if (indiff) { output += "```\n" }
            indiff = false
            def parts = line.tokenize()
            def path = (parts[2][0..-2]+'/'+parts[3]).tokenize('/').tail().join('/')
            if (parts[2].startsWith(from)) {
                outputRemoved += "* ${linkTo(from, path)}\n"
            } else {
                outputAdded += "* ${linkTo(to, path)}\n"
            }
            return
        }
        if (line.startsWith('diff ')) {
            if (indiff) { output += "```\n" }
            def path = line.tokenize().last().tokenize('/').tail().join('/')
            output += "* ${linkTo(to, path)}:\n```diff\n"
            indiff = true
            return
        }
        if (line.startsWith('---') | line.startsWith('+++')) {
            return
        }
        output += "${line}\n"
    }
    if (indiff) { output +=  "```\n" }
    output = "### Änderungen\n" + output
    if (outputAdded) { output = "### Hinzugefügt\n" + outputAdded + "\n" + output }
    if (outputRemoved) { output = "### Entfernt\n" + outputRemoved + "\n" + output }
    output = "## Anpassungen\n" + output
    return output
}
def steps = [
        '02_installation': "01_voraussetzungen",
        '03_konfiguration': "02_installation",
        '04_serviceprovider': "03_konfiguration",
        '05_integration': "04_serviceprovider",
        '06_metarefresh': "05_integration",
        '07_authproc': "06_metarefresh",
//        '08_production': "07_authproc",
//        '09_extras': "08_production",
]
steps.each {step, ancestor ->
    println "step ${ancestor} -> ${step}"
    def mdOutput = diff2md(ancestor, step)
    def readme = new File("${step}/README.md")
    def oldReadme = readme.text
    def newReadme = ""
    def inAuto = false
    oldReadme.eachLine { line ->
        if (line == "[//]: # (AUTOGENERATE END)") { inAuto = false }
        if (!inAuto) { newReadme += "${line}\n"}
        if (line == "[//]: # (AUTOGENERATE START)") { inAuto = true; newReadme += "${mdOutput}\n" }
    }
    readme.write(newReadme)
}


