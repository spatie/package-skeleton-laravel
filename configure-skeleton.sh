#!/bin/bash

git_name=`git config user.name`;
git_email=`git config user.email`;

read -p "Author name ($git_name): " author_name
author_name=${author_name:-$git_name}

read -p "Author email ($git_email): " author_email
author_email=${author_email:-$git_email}

username_guess=${author_name//[[:blank:]]/}
read -p "Author username ($username_guess): " author_username
author_username=${author_username:-$username_guess}

current_directory=`pwd`
current_directory=`basename $current_directory`
read -p "Package name ($current_directory): " package_name
package_name=${package_name:-$current_directory}

read -p "Package description: " package_description

echo
echo -e "Author: $author_name ($author_username, $author_email)"
echo -e "Package: $package_name <$package_description>"

echo
echo "This script will replace the above values in all files in the project directory and reset the git repository."
read -p "Are you sure you wish to continue? (n/y) " -n 1 -r

echo
if [[ ! $REPLY =~ ^[Yy]$ ]]
then
    [[ "$0" = "$BASH_SOURCE" ]] && exit 1 || return 1
fi

echo

rm -rf .git
git init

echo

find . -type f -exec sed -i '' -e "s/:author_name/$author_name/" {} \;
find . -type f -exec sed -i '' -e "s/:author_username/$author_username/" {} \;
find . -type f -exec sed -i '' -e "s/:author_email/$author_email/" {} \;
find . -type f -exec sed -i '' -e "s/:package_name/$package_name/" {} \;
find . -type f -exec sed -i '' -e "s/:package_description/$package_description/" {} \;

sed -i '' -e "/^\*\*Note:\*\* Replace/d" README.md

echo "Replaced all values and reset git directory, self destructing in 3... 2... 1..."

rm -- "$0"
