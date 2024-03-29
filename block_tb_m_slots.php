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
 * Content Box block
 *
 * @package    block_tb_m_slots
 * @copyright  2020 Leeloo LXP (https://leeloolxp.com)
 * @author     Leeloo LXP <info@leeloolxp.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * This block simply outputs the Benefits Spots.
 *
 * @copyright  2020 Leeloo LXP (https://leeloolxp.com)
 * @author     Leeloo LXP <info@leeloolxp.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_tb_m_slots extends block_base {

    /**
     * Initialize.
     *
     */
    public function init() {
        $this->title = get_string('pluginname', 'block_tb_m_slots');
    }

    /**
     * Return contents of tb_m_slots block
     *
     * @return stdClass contents of block
     */
    public function get_content() {

        global $CFG;

        if ($this->content !== null) {
            return $this->content;
        }

        $leeloolxplicense = get_config('block_tb_m_slots')->license;
        $settingsjson = get_config('block_tb_m_slots')->settingsjson;
        $resposedata = json_decode(base64_decode($settingsjson));

        if (!isset($resposedata->data->marketing_data)) {
            if ($this->page->user_is_editing()) {
                $this->title = get_string('displayname', 'block_tb_m_slots');
            } else {
                $this->title = '';
            }
            $this->content = new stdClass();
            $this->content->text = '';
            $this->content->footer = '';
            return $this->content;
        }

        $autoslide = @$resposedata->data->autoslide;
        $mdata = @$resposedata->data->marketing_data;

        if (empty($resposedata->data->block_title)) {
            if ($this->page->user_is_editing()) {
                $resposedata->data->block_title = get_string('displayname', 'block_tb_m_slots');
            } else {
                $resposedata->data->block_title = '';
            }
        }

        $summaryformatoptions = new stdClass();
        $summaryformatoptions->noclean = false;
        $summaryformatoptions->overflowdiv = false;
        $summaryformatoptions->filter = true;

        $this->title = format_text($resposedata->data->block_title, 1, $summaryformatoptions);

        $this->page->requires->jquery();
        $this->page->requires->js(new moodle_url('/blocks/tb_m_slots/js/owl.carousel.js'));
        if ($autoslide == 1) {
            $this->page->requires->js(new moodle_url('/blocks/tb_m_slots/js/owlslider-auto.js'));
        } else {
            $this->page->requires->js(new moodle_url('/blocks/tb_m_slots/js/owlslider.js'));
        }

        $this->content = new stdClass();
        $this->content->text = '<div class="tb_m_slots owl-carousel owl-theme">';

        foreach ($mdata as $mdatasing) {
            $this->content->text .= '<div id="content_box" class="content_box">';

            $this->content->text .= '<div class="content_img">';
            $this->content->text .= '<a href="' . $mdatasing->box_1_link . '"><img src="' . $mdatasing->box_1_img . '"/></a>';
            $this->content->text .= '</div>';

            $this->content->text .= '<div class="content_title">';
            $this->content->text .= format_text($mdatasing->box_1_title, 1, $summaryformatoptions);
            $this->content->text .= '</div>';

            $this->content->text .= '<div class="content_des">';
            $this->content->text .= format_text($mdatasing->box_1_desc, 1, $summaryformatoptions);
            $this->content->text .= '</div>';

            $this->content->text .= '</div>';
        }

        $this->content->text .= '</div>';

        $this->content->footer = '';

        return $this->content;
    }

    /**
     * Allow the block to have a configuration page
     *
     * @return boolean
     */
    public function has_config() {
        return true;
    }

    /**
     * Locations where block can be displayed
     *
     * @return array
     */
    public function applicable_formats() {
        return array('all' => true);
    }
}
