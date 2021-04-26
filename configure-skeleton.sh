#!/bin/bash
# 'return' when run as "source <script>" or ". <script>", 'exit' otherwise
[[ "$0" != "${BASH_SOURCE[0]}" ]] && safe_exit="return" || safe_exit="exit"

script_name=$(basename "$0")

ask_question() {
    # ask_question <question> <default>
    local ANSWER
    read -r -p "$1 ($2): " ANSWER
    echo "${ANSWER:-$2}"
}

confirm() {
    # confirm <question> (default = N)
    local ANSWER
    read -r -p "$1 (y/N): " -n 1 ANSWER
    echo " "
    [[ "$ANSWER" =~ ^[Yy]$ ]]
}

slugify() {
    # slugify <input> <separator>
    # Jack, Jill & Clémence LTD => jack-jill-clemence-ltd
    # inspiration: https://github.com/pforret/bashew/blob/master/template/normal.sh
    separator="$2"
    [[ -z "$separator" ]] && separator="-"
    # shellcheck disable=SC2020
    echo "$1" |
        tr '[:upper:]' '[:lower:]' |
        tr 'àáâäæãåāçćčèéêëēėęîïííīįìłñńôöòóœøōõßśšûüùúūÿžźż' 'aaaaaaaaccceeeeeeeiiiiiiilnnoooooooosssuuuuuyzzz' |
        awk '{
        gsub(/[\[\]@#$%^&*;,.:()<>!?\/+=_]/," ",$0);
        gsub(/^  */,"",$0);
        gsub(/  *$/,"",$0);
        gsub(/  */,"-",$0);
        gsub(/[^a-z0-9\-]/,"");
        print;
        }' |
        sed "s/-/$separator/g"
}

titlecase() {
    # titlecase <input> <separator>
    # Jack, Jill & Clémence LTD => JackJillClemenceLtd
    separator="${2:-}"
    echo "$1" |
        tr '[:upper:]' '[:lower:]' |
        tr 'àáâäæãåāçćčèéêëēėęîïííīįìłñńôöòóœøōõßśšûüùúūÿžźż' 'aaaaaaaaccceeeeeeeiiiiiiilnnoooooooosssuuuuuyzzz' |
        awk '{ gsub(/[\[\]@#$%^&*;,.:()<>!?\/+=_-]/," ",$0); print $0; }' |
        awk '{
        for (i=1; i<=NF; ++i) {
            $i = toupper(substr($i,1,1)) tolower(substr($i,2))
        };
        print $0;
        }' |
        sed "s/ /$separator/g"
}

git_name=$(git config user.name)
author_name=$(ask_question "Author name" "$git_name")

git_email=$(git config user.email)
author_email=$(ask_question "Author email" "$git_email")

username_guess=$(git config remote.origin.url | cut -d: -f2-)
username_guess=$(dirname "$username_guess")
username_guess=$(basename "$username_guess")
author_username=$(ask_question "Author username" "$username_guess")

vendor_name=$(ask_question "Vendor name" "$author_username")
vendor_slug=$(slugify "$vendor_name")
VendorName=$(titlecase "$vendor_name" "")

current_directory=$(pwd)
folder_name=$(basename "$current_directory")

package_name=$(ask_question "Package name" "$folder_name")
package_slug=$(slugify "$package_name" "-")

ClassName=$(titlecase "$package_name")
ClassName=$(ask_question "Class Name" "$ClassName")
package_description=$(ask_question "Package description" "This is my package $ClassName")

echo -e "------"
echo -e "Author    : $author_name ($author_username, $author_email)"
echo -e "Vendor    : $vendor_name ($vendor_slug)"
echo -e "Package   : $package_slug <$package_description>"
echo -e "Namespace : $VendorName\\$ClassName"
echo -e "ClassName : $ClassName"
echo -e "------"

files=$(grep -E -r -l -i ":author|:vendor|:package|:short|spatie|skeleton" --exclude-dir=vendor ./* ./.github/* | grep -v "$script_name")

echo "This script will replace the above values in all relevant files in the project directory."

if ! confirm "Modify files?"; then
    $safe_exit 1
fi

grep -E -r -l -i ":author|:vendor|:package|VendorName|skeleton" --exclude-dir=vendor ./* ./.github/* \
| grep -v "$script_name" \
| while read -r file ; do
    new_file="$file"
    new_file="${new_file//Skeleton/$ClassName}"
    new_file="${new_file//skeleton/$package_slug}"
    new_file="${new_file//laravel_/}"
    new_file="${new_file//laravel-/}"

    echo "adapting file $file -> $new_file"
        temp_file="$file.temp"
        < "$file" \
          sed "s/:author_name/$author_name/g" \
        | sed "s/:author_username/$author_username/g" \
        | sed "s/author@domain.com/$author_email/g" \
        | sed "s/:vendor_name/$vendor_name/g" \
        | sed "s/vendor_slug/$vendor_slug/g" \
        | sed "s/VendorName/$VendorName/g" \
        | sed "s/:package_name/$package_name/g" \
        | sed "s/package_slug/$package_slug/g" \
        | sed "s/skeleton/$package_slug/g" \
        | sed "s/Skeleton/$ClassName/g" \
        | sed "s/:package_description/$package_description/g" \
        | sed "/^\[\]\(delete\) /d" \
        > "$temp_file"
        rm -f "$file"
        mv "$temp_file" "$new_file"
done

if confirm "Execute composer install and phpunit test"; then
    composer install && ./vendor/bin/phpunit
fi

if confirm 'Let this script delete itself (since you only need it once)?'; then
    echo "Delete $0 !"
    sleep 1 && rm -- "$0"
fi
