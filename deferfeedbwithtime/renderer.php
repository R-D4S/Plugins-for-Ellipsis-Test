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
 * Defines the renderer for the deferred feedback behaviour.
 *
 * @package    qbehaviour
 * @subpackage deferredfeedback
 * @copyright  2009 The Open University
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die();


/**
 * Renderer for outputting parts of a question belonging to the deferred
 * feedback behaviour.
 *
 * @copyright  2009 The Open University
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class qbehaviour_deferfeedbwithtime_renderer extends qbehaviour_renderer {

    public function controls(question_attempt $qa, question_display_options $options) {
        global $PAGE,$DB;
        $result="";
        $url = $_SERVER['REQUEST_URI'];
        $is_rew = stripos($url, 'review');

        if(!$is_rew){
            $namecookie = "att".($qa->get_database_id())."ques".($qa->get_question_id());
            if(!isset($_COOKIE[$namecookie])){
                setcookie($namecookie,0, time()+3600);
            }

            $PAGE->requires->js_call_amd('qbehaviour_deferfeedbwithtime/secwatch', 'init', [$namecookie]);
        }
        else{
            $t = $DB->get_record("time_for_question", ['attempt_id'=>$qa->get_database_id()], 'timeon');
            $result .="<br><br><br><p style='font-style: oblique;'>Время, затраченное на вопрос: ".($t->timeon)." сек.</p>";

        }


        return $result;
    }
}
