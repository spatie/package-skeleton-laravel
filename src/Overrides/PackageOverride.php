<?php

namespace VendorName\Skeleton\Overrides;

use VendorName\Skeleton\Overrides\InstallCommandOverride as InstallCommandOverrideBlog;
use Spatie\LaravelPackageTools\Package as PackageBlog;

class PackageOverride extends PackageBlog
{
    public function hasInstallCommand($callable): static
    {
        $installCommand = new InstallCommandOverrideBlog($this);

        $callable($installCommand);

        $this->consoleCommands[] = $installCommand;

        return $this;
    }
}
