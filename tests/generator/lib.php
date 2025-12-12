<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * mod_bigbluebuttonbn data generator
 *
 * @package    mod_nosteess
 * @author     Jesus Federico  (jesus [at] blindsidenetworks [dt] com)
 */

use core\plugininfo\mod;

class mod_nostress_generator extends \testing_module_generator {

    /**
     * Creates an instance of bigbluebuttonbn for testing purposes.
     *
     * @param array|stdClass $record data for module being generated.
     * @param null|array $options general options for course module.
     * @return stdClass record from module-defined table with additional field cmid
     */
    public function create_instance($record = null, ?array $options = null) {
        // Prior to creating the instance, make sure that the BigBlueButton module is enabled.
        $modules = \core_plugin_manager::instance()->get_plugins_of_type('mod');
        if (!$modules['nostress']->is_enabled()) {
            mod::enable_plugin('nostress', true);
        }

        $now = time();
        $defaults = [
            "timecreated" => $now,
            "timemodified" => $now,
        ];
        $record = (array) $record;

        return parent::create_instance((object) $record, (array) $options);
    }
}

