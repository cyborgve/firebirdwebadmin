<?php
// File           tb_show.php / FirebirdWebAdmin
// Purpose        html sequence for the tb_show-panel in tables.php
// Author         Lutz Brueckner <irie@gmx.de>
// Copyright      (c) 2000-2006 by Lutz Brueckner,
//                published under the terms of the GNU General Public Licence v.2,
//                see file LICENCE for details

require 'panels/tb_dropfields.php';

$tcnt = 0;
if ($s_connected == true && is_array($s_tables)):

    ?>
    <form method="post" action="<?php echo url_session($_SERVER['PHP_SELF']); ?>#tb_show_selectableform" name="tb_show_selectableform" class="form-horizontal">
    <input type="submit" name="btn_viewselectable" value="<?=$button_strings['OpenSelectableMode']?>" class="btn btn-default btn-xs">
    </form>
    <?php

    foreach ($s_tables as $tablename => $properties) {
        if ($properties['is_view'] == true) {
            continue;
        }
        ++$tcnt;

        $title = $tablename;
        if ($s_tables_counts == true  &&  isset($properties['count'])) {
            $title .= '&nbsp;['.$properties['count'].']';
        }

        $fold_url = fold_detail_url('table', $properties['status'], $tablename, $title);
        $comment_url = "javascript:requestCommentArea('table', '".$tablename."');";

        echo '      <div id="'.'t_'.$tablename."\" class=\"det\">\n";

        if ($properties['status'] == 'open') {
            echo get_opened_table($tablename, $title, $fold_url, $comment_url, 'tc_'.$tablename);
        } else {   // $properties['status'] == 'close'
            echo get_closed_detail($title, $fold_url, $comment_url, 'tc_'.$tablename);
        }

        echo "      </div>\n";
    }    // foreach $s_tables

    echo '<br><form method="post" action="'.url_session($_SERVER['PHP_SELF'])."#tb_show\" name=\"tb_show_form\" class=\"form-horizontal\">\n"

       .' <label>'.get_checkbox('tb_show_counts', '1', $s_tables_counts).' '.$tb_strings['DispCounts'].'</label>'
       .' <label>'.get_checkbox('tb_show_cnames', '1', $s_tables_cnames).' '.$tb_strings['DispCNames'].'</label>'
       .' <label>'.get_checkbox('tb_show_def', '1', $s_tables_def).' '.$tb_strings['DispDef'].'</label>'
       .' <label>'.get_checkbox('tb_show_comp', '1', $s_tables_comp).' '.$tb_strings['DispComp'].'</label>'
       .' <label>'.get_checkbox('tb_show_comments', '1', $s_tables_comment).' '.$tb_strings['DispComm']."</label><br />\n"
       .'  <input type="submit" name="tb_show_reload" value="'.$button_strings['Reload']."\" class=\"btn btn-default btn-xs\">\n";
        if ($tcnt > 1) {
            echo '  <input type="submit" name="tb_table_open" value="'.$button_strings['OpenAll']."\" class=\"btn btn-default btn-xs\">\n"
               .'  <input type="submit" name="tb_table_close" value="'.$button_strings['CloseAll']."\" class=\"btn btn-default btn-xs\">\n";
        }
    echo "</form>\n";

endif;
