# Release instructions

The following steps should be performed each and every time a new release is made.

1. Switch to the `main` branch in your local installation
2. Run `git pull` to get the latest code changes
4. Edit [CHANGELOG.md](CHANGELOG.md) following the [Keep a Changelog](https://keepachangelog.com) convention
5. Run `git commit -m "Updates CHANGELOG" && git push`
6. Run `git tag vX.X.X && git push --tags`, replacing `X` with the appropriate version number
