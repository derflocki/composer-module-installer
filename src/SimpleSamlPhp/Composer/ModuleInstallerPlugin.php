<?php

namespace SimpleSamlPhp\Composer;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;
use React\Promise\PromiseInterface;

use function file_exists;
use function sprintf;

class ModuleInstallerPlugin implements PluginInterface
{
    /**
     * Apply plugin modifications to Composer
     *
     * @param \Composer\Composer $composer
     * @param \Composer\IO\IOInterface $io
     */
    public function activate(Composer $composer, IOInterface $io)
    {
        $installer = new ModuleInstaller($io, $composer);
        $composer->getInstallationManager()->addInstaller($installer);
    }


    /**
     * Remove any hooks from Composer
     *
     * This will be called when a plugin is deactivated before being
     * uninstalled, but also before it gets upgraded to a new version
     * so the old one can be deactivated and the new one activated.
     *
     * @param \Composer\Composer $composer
     * @param \Composer\IO\IOInterface $io
     */
    public function deactivate(Composer $composer, IOInterface $io)
    {
        // Not implemented
    }


    /**
     * Prepare the plugin to be uninstalled
     *
     * This will be called after deactivate.
     *
     * @param \Composer\Composer $composer
     * @param \Composer\IO\IOInterface $io
     */
    public function uninstall(Composer $composer, IOInterface $io)
    {
        $installPath = $this->getPackageBasePath($package);

        $io = $this->io;
        $outputStatus = function () use ($io, $installPath) {
            $io->write(
                sprintf('Deleting %s - %s', $installPath, !file_exists($installPath) ? '<comment>deleted</comment>' : '<error>not deleted</error>')
            );
        };

        // If not, execute the code right away as parent::uninstall executed synchronously (composer v1, or v2 without async)
        $outputStatus();
    }
}
