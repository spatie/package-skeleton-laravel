$git_name = git config user.name
$git_email = git config user.email

$author_name = Read-Host "Author name ($($git_name)): "
$author_name = @{$true=$git_name;$false=$author_name}[($author_name -eq "")]

$author_email = Read-Host "Author email ($($git_email)): "
$author_email = @{$true=$git_email;$false=$author_email}[($author_email -eq "")]

$current_directory = (Get-Item $PSCommandPath ).Directory.Name
$package_name = Read-Host "Package name ($($current_directory)): "
$package_name = @{$true=$current_directory;$false=$package_name}[($package_name -eq "")]

$package_description = Read-Host "Package description: "

echo ""
echo "Author: $($author_name) ($($author_username), $($author_email))"
echo "Package: $($package_name) <$($package_description)>"

echo ""
echo "This script will replace the above values in all files in the project directory and reset the git repository."
echo ""

$reply = Read-Host -Prompt "Are you sure you wish to continue? (n/y) "
if ( $reply -match "[nN]" ) {
    exit
}

echo ""


Remove-Item .\.git -Recurse -ErrorAction Ignore
git init

echo ""

$files = Get-ChildItem (Get-Item -Path ".\").FullName -Recurse

for ($i=0; $i -lt $files.Count; $i++) {
    if(Test-Path $files[$i].FullName -pathType leaf){
        
        (Get-Content $files[$i].FullName) -replace '\:author_name', $author_name | Set-Content $files[$i].FullName
        (Get-Content $files[$i].FullName) -replace '\:author_username', $author_username | Set-Content $files[$i].FullName
        (Get-Content $files[$i].FullName) -replace '\:author_email', $author_email | Set-Content $files[$i].FullName
        (Get-Content $files[$i].FullName) -replace '\:package_name', $package_name | Set-Content $files[$i].FullName
        (Get-Content $files[$i].FullName) -replace '\:package_description', $package_description | Set-Content $files[$i].FullName

        if($files[$i].Name -eq "README.md") {
            (Get-Content $files[$i].FullName) -replace '\*\*Note:\*\* Replace(.+)', '' | Set-Content $files[$i].FullName
        }

    }
}

echo "Replaced all values and reset git directory, self destructing in 3... 2... 1..."


Remove-Item .\configure-skeleton.sh -ErrorAction Ignore
Remove-Item .\configure-skeleton.ps1 -ErrorAction Ignore
