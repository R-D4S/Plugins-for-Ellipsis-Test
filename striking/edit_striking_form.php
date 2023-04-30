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
 * Defines the editing form for the shortanswer question type.
 *
 * @package    qtype
 * @subpackage striking
 * @copyright  2007 Jamie Pratt
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die();


/**
 * Short answer question editing form definition.
 *
 * @copyright  2007 Jamie Pratt
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class qtype_striking_edit_form extends question_edit_form {

    protected function definition_inner($mform) {
        /*$menu = array(
            get_string('caseno', 'qtype_striking'),
            get_string('caseyes', 'qtype_striking')
        );
        $mform->addElement('select', 'usecase',
                get_string('casesensitive', 'qtype_striking'), $menu);*/



        $mform->addElement('text', 'sentence', "sentence",
            array('size' => 50, 'maxlength' => 255));
        $mform->setType('sentence', PARAM_TEXT);
        $mform->addRule('sentence', null, 'required', null, 'client');



        $mform->addElement('static', 'answersinstruct',
                get_string('correctanswers', 'qtype_striking'),
                get_string('filloutoneanswer', 'qtype_striking'));
        $mform->addElement('static', 'answersinstruct',
            '',
            get_string('disclaimer', 'qtype_shortanswerrea'));

        $mform->closeHeaderBefore('answersinstruct');

        $this->add_per_answer_fields($mform, get_string('answerno', 'qtype_striking', '{no}'),
                question_bank::fraction_options());



        $this->add_interactive_settings();
    }

    protected function get_more_choices_string() {
        return get_string('addmoreanswerblanks', 'qtype_striking');
    }

    protected function data_preprocessing($question) {
        $question = parent::data_preprocessing($question);
        $question = $this->data_preprocessing_answers($question);
        $question = $this->data_preprocessing_hints($question);
        global $PAGE;

        $PAGE->requires->js_call_amd('qtype_striking/form', 'init');

        return $question;
    }

    public function js_call() {
        global $PAGE;
        //new moodle_url($CFG->wwwroot . '/local/my_localplugin/myjavascript.js')
        $PAGE->requires->js_call_amd('amd/src/form.js', 'init');
    }

    public function validation($data, $files) {
        $errors = parent::validation($data, $files);
        $answers = $data['answer'];
        $answercount = 0;
        $maxgrade = true;
        foreach ($answers as $key => $answer) {
            $trimmedanswer = trim($answer);
            if ($trimmedanswer !== '') {
                $answercount++;
                if ($data['fraction'][$key] == 1) {
                    $maxgrade = true;
                }
            } else if ($data['fraction'][$key] != 0 ||
                    !html_is_blank($data['feedback'][$key]['text'])) {
                $errors["answeroptions[{$key}]"] = get_string('answermustbegiven', 'qtype_striking');
                $answercount++;
            }
        }
        if ($answercount==0) {
            $errors['answeroptions[0]'] = get_string('notenoughanswers', 'qtype_striking', 1);
        }
        //if ($maxgrade == false) {
         //   $errors['answeroptions[0]'] = get_string('fractionsnomax', 'question');
       // }
        return $errors;
    }

    public function qtype() {
        return 'striking';
    }
}
