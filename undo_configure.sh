#!/usr/bin/env bash
echo "## revert to last commit"
git reset head --hard
git clean -f -d
