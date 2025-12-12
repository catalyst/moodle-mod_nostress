<?php
// This file is part of Moodle - https://moodle.org/
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
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Library of interface functions and constants.
 *
 * @package     mod_nostress
 * @copyright   2025 Brendan Heywood <brendan@catalyst-au.net>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Return if the plugin supports $feature.
 *
 * @param string $feature Constant representing the feature.
 * @return true | null True if the feature is supported, null otherwise.
 */
function nostress_supports($feature) {
    switch ($feature) {
        case FEATURE_MOD_INTRO:
            return true;
        default:
            return null;
    }
}

/**
 * Saves a new instance of the mod_nostress into the database.
 *
 * Given an object containing all the necessary data, (defined by the form
 * in mod_form.php) this function will create a new instance and return the id
 * number of the instance.
 *
 * @param object $moduleinstance An object from the form.
 * @param mod_nostress_mod_form $mform The form.
 * @return int The id of the newly inserted record.
 */
function nostress_add_instance($moduleinstance, $mform = null) {
    global $DB;

    $moduleinstance->timecreated = time();

    $id = $DB->insert_record('nostress', $moduleinstance);

    return $id;
}

/**
 * Updates an instance of the mod_nostress in the database.
 *
 * Given an object containing all the necessary data (defined in mod_form.php),
 * this function will update an existing instance with new data.
 *
 * @param object $moduleinstance An object from the form in mod_form.php.
 * @param mod_nostress_mod_form $mform The form.
 * @return bool True if successful, false otherwise.
 */
function nostress_update_instance($moduleinstance, $mform = null) {
    global $DB;

    $moduleinstance->timemodified = time();
    $moduleinstance->id = $moduleinstance->instance;

    return $DB->update_record('nostress', $moduleinstance);
}

/**
 * Removes an instance of the mod_nostress from the database.
 *
 * @param int $id Id of the module instance.
 * @return bool True if successful, false on failure.
 */
function nostress_delete_instance($id) {
    global $DB;

    $exists = $DB->get_record('nostress', ['id' => $id]);
    if (!$exists) {
        return false;
    }

    $DB->delete_records('nostress', ['id' => $id]);

    return true;
}

/**
 * Given a course_module object, this function returns any
 * "extra" information that may be needed when printing
 * this activity in a course listing.
 * See get_array_of_activities() in course/lib.php
 *
 * @global object
 * @param object $coursemodule
 * @return cached_cm_info|null
 */
function nostress_get_coursemodule_info($coursemodule) {
    global $DB;

    if ($label = $DB->get_record('label', array('id'=>$coursemodule->instance), 'id, name, intro, introformat')) {
        if (empty($label->name)) {
            // label name missing, fix it
            $label->name = "label{$label->id}";
            $DB->set_field('label', 'name', $label->name, array('id'=>$label->id));
        }
        $info = new cached_cm_info();
        // no filtering hre because this info is cached and filtered later
        $info->content = 'NO STRESS!!!<br>' . format_module_intro('label', $label, $coursemodule->id, false);
        $info->name  = $label->name;
        return $info;
    } else {
        return null;
    }
}

