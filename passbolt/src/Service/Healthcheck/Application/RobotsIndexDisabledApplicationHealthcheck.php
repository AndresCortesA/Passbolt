<?php
declare(strict_types=1);

/**
 * Passbolt ~ Open source password manager for teams
 * Copyright (c) Passbolt SA (https://www.passbolt.com)
 *
 * Licensed under GNU Affero General Public License version 3 of the or any later version.
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Passbolt SA (https://www.passbolt.com)
 * @license       https://opensource.org/licenses/AGPL-3.0 AGPL License
 * @link          https://www.passbolt.com Passbolt(tm)
 * @since         4.7.0
 */

namespace App\Service\Healthcheck\Application;

use App\Service\Healthcheck\HealthcheckCliInterface;
use App\Service\Healthcheck\HealthcheckServiceCollector;
use App\Service\Healthcheck\HealthcheckServiceInterface;
use Cake\Core\Configure;

class RobotsIndexDisabledApplicationHealthcheck implements HealthcheckServiceInterface, HealthcheckCliInterface
{
    /**
     * Status of this health check if it is passed or failed.
     *
     * @var bool
     */
    private bool $status = false;

    /**
     * @inheritDoc
     */
    public function check(): HealthcheckServiceInterface
    {
        $robots = strpos(Configure::read('passbolt.meta.robots'), 'noindex');
        $this->status = ($robots !== false);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function domain(): string
    {
        return HealthcheckServiceCollector::DOMAIN_APPLICATION;
    }

    /**
     * @inheritDoc
     */
    public function isPassed(): bool
    {
        return $this->status;
    }

    /**
     * @inheritDoc
     */
    public function level(): string
    {
        return HealthcheckServiceCollector::LEVEL_WARNING;
    }

    /**
     * @inheritDoc
     */
    public function getSuccessMessage(): string
    {
        return __('Search engine robots are told not to index content.');
    }

    /**
     * @inheritDoc
     */
    public function getFailureMessage(): string
    {
        return __('Search engine robots are not told not to index content.');
    }

    /**
     * @inheritDoc
     */
    public function getHelpMessage()
    {
        return __('Set passbolt.meta.robots to false in {0}.', CONFIG . 'passbolt.php');
    }

    /**
     * CLI Option for this check.
     *
     * @return string
     */
    public function cliOption(): string
    {
        return HealthcheckServiceCollector::DOMAIN_APPLICATION;
    }

    /**
     * @inheritDoc
     */
    public function getLegacyArrayKey(): string
    {
        return 'robotsIndexDisabled';
    }
}
