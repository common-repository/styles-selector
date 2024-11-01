<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<?php
function theme_list()
{
//Little snippet derived from the theme switcha plugin to show a drop down selectable list of active themes in the site.    
    $blog_id = get_current_blog_id();
	$blog_id = is_int($blog_id) ? $blog_id : 0;
	$themes = wp_get_themes(array('errors' => false , 'allowed' => true, 'blog_id' => $blog_id));
	$theme_names = array_keys($themes);
	$theme_names = array_map('strval', $theme_names);
	natcasesort($theme_names);
    return $theme_names;
}
function ss_displayThemes($ss_tab) {
    $theme_lst = theme_list();
	echo "<div id='theme".$ss_tab."' class='wrap metabox-holder columns-2 stylesel-metaboxes";
    if($ss_tab > 1){echo" hidden'>";}
    else {echo"'>";}
    echo "<h2 align='center'>Theme ".$ss_tab."</h2>";
	echo "<h3>Select wich themes will be alterable, the styles to alter and their new parameters.</h3>";
	echo "<select name='selected_theme_".$ss_tab."' id='selected_theme_".$ss_tab."' oninput=\"fillForm('".$ss_tab."')\">";
	for ($ss_count = 0; $ss_count < count($theme_lst); $ss_count++) {
		echo "<option value='".$theme_lst[$ss_count]."'>".$theme_lst[$ss_count]."</option>";
	}
	echo "</select>";
	echo "<h3>Should the selector be displayed at the head of the page?</h3>";
	echo "<input type='checkbox' id='disp_head_".$ss_tab."' name='disp_head_".$ss_tab."' oninput=\"fillForm('".$ss_tab."')\" />";
	echo "<h3>Choose a style for the selectors. You can also alter them changing the \"shortcode_sselector\" for the div and  \"widget_sselector\" for the selector classes.</h3>";
	echo "<table align='center'>";
	echo "	<tr align='center'>";
	echo "		<td width='50'>Choose a style for the selectors.</td>";
	echo "		<td width='50'>Custom CCS for \"shortcode_sselector\".</td>";
	echo "		<td width='50'>Custom CCS for \"widget_sselector\".</td>";
	echo "		<td width='50'>";
	echo "			<div class='shortcode_sselector_".$ss_tab."'>Select a style: ";
	echo "			</div>";
	echo "</td>";
	echo "	</tr>";
	echo "	<tr align='center'>";
	echo "		<td><select name='select_style_".$ss_tab."' id='select_style_".$ss_tab."' oninput=\"styleSelect('".$ss_tab."')\">";
	echo "			<option value='0'>Squared</option>";
	echo "			<option value='1'>Rounded</option>";
	echo "			<option value='2'>Custom</option>";
	echo "		</select></td>";
	echo "		<td><textarea id='select_sheet_div_".$ss_tab."' name='select_sheet_div_".$ss_tab."' cols='80' rows='4' class='all-options' disabled  oninput=\"styleSelect('".$ss_tab."')\">Select 'Custom' to edit.</textarea></td>";
	echo "		<td><textarea id='select_sheet_sel_".$ss_tab."' name='select_sheet_sel_".$ss_tab."' cols='80' rows='4' class='all-options' disabled  oninput=\"styleSelect('".$ss_tab."')\">Select 'Custom' to edit.</textarea></td>";
	echo "		<td style='width:150px'><div id='shortcode_sselector_".$ss_tab."'>";
	prepareAdmOutput($ss_tab);
	echo "		</div></td>";
	echo "	</tr>";
	echo "</table>";	
	echo "<!-- Same as the themes options the list of configurable styles and classes is fixed, in this case to ten different styles and classes. -->";
	echo "<h4>Options for this theme.</h4>";
	echo "<!-- Pure CSS accordion courtesy of Michael Rafaelle http://www.mraffaele.com/blog/2011/10/25/css-accordion-no-javascript/. -->";    
		echo "<div class='accordion vertical'>";    
	for ($ss_count = 1; $ss_count < 11; $ss_count++) {

		echo "    <ul>";
		echo "        <li>";
		echo "            <input type='checkbox' id='checkbox-".$ss_tab."_".$ss_count."' name='checkbox-accordion' />";
		echo "            <label for='checkbox-".$ss_tab."_".$ss_count."'>Option ".$ss_count."</label>";
		echo "            <div class='content'>";
		echo "            <fieldset class='stylesel-admin-colors'>";
		echo "                <table align='center' width='100%'>";
		echo "                    <tr align='center'>";
		echo "                      <td>Type a name for the option:&nbsp;</td>";
		echo "                      <td>Class or element?&nbsp;</td>";
		echo "                      <td>Name of the element to manipulate:&nbsp;</td>";
		echo "                      <td>Pick the color of the background:&nbsp;</td>";
		echo "						<td>Pick the color of the font:&nbsp;</td>";
		echo "						<td>Background transparency:&nbsp;</td>";
		echo "						<td>Font transparency:&nbsp;</td>";
		echo "						<td>Active?</td>";
		echo "                    </tr>";
		echo "                    <tr align='center'>";
		echo "                      <td><input type='text' value='opt_name_".$ss_tab."_".$ss_count."' id='opt_name_".$ss_tab."_".$ss_count."' class='all-options' oninput=\"fillForm('".$ss_tab."_".$ss_count."')\" /></td>";
		echo "						<td>";
		echo "							<select name='theme_option_type_".$ss_tab."_".$ss_count."' id='theme_option_type_".$ss_tab."_".$ss_count."'  oninput=\"fillForm('".$ss_tab."_".$ss_count."')\"/>";
		echo "							<option value='0'>Class</option>";
		echo "		                    <option value='1'>Element</option>";
		echo "							</select>";
		echo "						</td>";
		echo "                      <td><input type='text' id='element_".$ss_tab."_".$ss_count."' value='element_".$ss_tab."_".$ss_count."' class='all-options' oninput=\"fillForm('".$ss_tab."_".$ss_count."')\" /></td>";
		echo "                        <!-- clickColor(char id of the control, int bakground color(0) or font color(1)) -->";
		echo "                      <td><input type='color' id='bg_colorPicker_".$ss_tab."_".$ss_count."' oninput=\"clickColor('".$ss_tab."_".$ss_count."',0)\" style='width:50px;' value='#ff0000'></td>";
		echo "						<td><input type='color' id='fn_colorPicker_".$ss_tab."_".$ss_count."' oninput=\"clickColor('".$ss_tab."_".$ss_count."',1)\" style='width:50px;' value='#ff0000'></td>";
		echo "                      <td><div class='slidecontainer'><input type='range' min='1' max='100' value='50' class='slider' id='myRange_".$ss_tab."_".$ss_count."' oninput=\"myslider('".$ss_tab."_".$ss_count."',0);\"></div></td>";
		echo "                      <td><div class='slidecontainer'><input type='range' min='1' max='100' value='50' class='slider' id='myRangeFont_".$ss_tab."_".$ss_count."' oninput=\"myslider('".$ss_tab."_".$ss_count."');\"></div></td>";
		echo "						<td><label class='ss_switch'><input type='checkbox'  id='option_".$ss_tab."_".$ss_count."' oninput=\"fillForm('".$ss_tab."_".$ss_count."')\"><span class='sw_slider'></label></td>";
        echo "                    </tr>";
		echo "                </table>";
		echo "				<div class='ss_bg_testcolor'><div id='test_color_".$ss_tab."_".$ss_count."'>Color TEST</div></div>";
		echo "            </fieldset>";
		echo "            </div>";
		echo "        </li>";
	}
		echo "    </ul>";
		echo "</div>";
    
	echo "</fieldset>";
	echo "</div>";
}
//Little function to display the configurable styles.
function ss_displayOptions($ss_tab) {
	echo "<select name='ss_selected_theme".$ss_tab."' id='styleselectorthemes".$ss_tab."'>";
	}
?>
<div class="wrap">
	<h2><?php echo esc_html(get_admin_page_title()); ?></h2>
	<h2 class="nav-tab-wrapper">
<!--
	The function chngtab(char Target ID, char Class of targets, int Tab index) uses the name of the element, the class of the boxes we are using and the index of the tab we want to highligt.
	Did this because I found the jQuery method too esoteric and didn't understood what the heck was going on there with all that function names, $variables and so on.
-->
		<a href="#theme1" class="nav-tab nav-tab-active" onclick="chngtab('theme1','stylesel-metaboxes',0);return false;">Theme 1</a>
		<a href="#theme2" class="nav-tab" onclick="chngtab('theme2','stylesel-metaboxes',1);return false;">Theme 2</a>
		<a href="#theme3" class="nav-tab" onclick="chngtab('theme3','stylesel-metaboxes',2);return false;">Theme 3</a>
    	<a href="#theme3" class="nav-tab" onclick="chngtab('theme4','stylesel-metaboxes',3);return false;">Theme 4</a>
    	<a href="#theme3" class="nav-tab" onclick="chngtab('theme5','stylesel-metaboxes',4);return false;">Theme 5</a>
		<a href="#theme3" class="nav-tab" onclick="chngtab('Help','stylesel-metaboxes',5);return false;">Help</a>
	</h2>
    
<!-- ATM 5 themes are configurable, no timeline scheduled to change this. -->
	<?php for ($ss_tab = 1; $ss_tab < 6; $ss_tab++) {ss_displayThemes($ss_tab);} ?>
    <form method="post" name="styleselector_options" action="options.php">
<div id="ss_data_hidden" style="display: none;">
<!-- http://ottopress.com/2009/wordpress-settings-api-tutorial/  A very detailed and short tutorial about how to use options to save your data-->
<?php
settings_fields($this->plugin_name);
$options = get_option($this->plugin_name);
?>
<?php
/**
 * Note for future me because I will surely forget what I did here.
 * 
 * In order to work, you need also options_update() in class-pluginname-admin.php, initialize it in class-pluginname.php define_admin_hooks()
 * ss_pass_stored() in js to pass the stored values to the forntend, and use some scripts in the js to pass the work values to the form values.
 * Be aware of the name tag wich is the one used by wordpress, and the id tag, wich is the one i use to identify the fields.
 * Filds preceded with ss_ are the wordpress ones, the other are work ones to use in this page only.
 * 
 */
$ss_fieldTypes = array("ss_disp_head", "ss_select_style", "ss_select_sheet_div", "ss_select_sheet_sel", "ss_selected_theme", "ss_opt_name", "ss_theme_option_type","ss_element","ss_bg_colorPicker","ss_fn_colorPicker","ss_myRange","ss_myRangeFont","ss_option");
for ($ss_tab = 1; $ss_tab < 6; $ss_tab++)
{
    $ss_fieldId = $ss_fieldTypes[0]."_".$ss_tab;
    echo $ss_fieldId."<input type='text' name='".$this->plugin_name."[".$ss_fieldId."]' id='".$ss_fieldId."' value=\"".$options[$ss_fieldId]."\"class='all-options' />";

    $ss_fieldId = $ss_fieldTypes[1]."_".$ss_tab;
    echo $ss_fieldId."<input type='text' name='".$this->plugin_name."[".$ss_fieldId."]' id='".$ss_fieldId."' value=\"".$options[$ss_fieldId]."\"class='all-options' />";

    $ss_fieldId = $ss_fieldTypes[2]."_".$ss_tab;
    echo $ss_fieldId."<input type='text' name='".$this->plugin_name."[".$ss_fieldId."]' id='".$ss_fieldId."' value=\"".$options[$ss_fieldId]."\"class='all-options' />";

    $ss_fieldId = $ss_fieldTypes[3]."_".$ss_tab;
    echo $ss_fieldId."<input type='text' name='".$this->plugin_name."[".$ss_fieldId."]' id='".$ss_fieldId."' value=\"".$options[$ss_fieldId]."\"class='all-options' />";

    $ss_fieldId = $ss_fieldTypes[4]."_".$ss_tab;
    echo $ss_fieldId."<input type='text' name='".$this->plugin_name."[".$ss_fieldId."]' id='".$ss_fieldId."' value=\"".$options[$ss_fieldId]."\"class='all-options' />";

    echo "<fieldset class='stylesel-admin-colors'>";
    for ($ss_count = 1; $ss_count < 11; $ss_count++)
        {
        for ($ss_fieldCount = 5; $ss_fieldCount < count($ss_fieldTypes); $ss_fieldCount++)
            {
            $ss_fieldId = $ss_fieldTypes[$ss_fieldCount]."_".$ss_tab."_".$ss_count;
            echo $ss_fieldId."<input type='text' name='".$this->plugin_name."[".$ss_fieldId."]' id='".$ss_fieldId."' value=\"".$options[$ss_fieldId]."\"class='all-options' />";
            }
        }
	echo "</fieldset>";
}
?>
    </div>
	<?php submit_button('Save all changes', 'primary','submit', TRUE); ?>
    </form>
<!-- Help tab-->	
		<div id='Help' class='wrap metabox-holder columns-2 stylesel-metaboxes' hidden>
		<h2 align="center">Help</h2>
		<br><br>
		<h3 align="center">General</h3>
		<p>This plugin creates a select menu that lets a user change the color style of a page or post to be changed acording the settings
		that the blog administrator sets. </p>
		<p>The admin can choose up to five different themes from the installed ones to be changed by selecting them in a drop down at the
		beginning of each tab of the configuration page. Note that you can select the same theme several times if you run out of mods.</p>
		<p>At each theme tab the admin can set up to ten color modifications to classes or individual elements.</p>		
		<p>You can configure the style of the selector for each theme. Also you can force the selector to be displayed at the top of the page instead of using a widget or a shortcode.</p>
		<h4 align="center">Example</h4>	
		<p>Copy this in the  "shortcode_sselector" box.<br> <code>font-size: 1.25em; font-weight: bolder; width: 100%; text-align:center; box-sizing: border-box; box-sizing: border-box; border: 2px solid #ccc; border-radius: 7px; padding: 9px 15px 9px 20px;</code></p>
		<p> And this in the "widget_sselector".<br> <code>font-size: 1.25em; font-weight: bolder; width: 100%; text-align:center; box-sizing: border-box; box-sizing: border-box; border: 2px solid #ccc; border-radius: 7px; padding: 9px 15px 9px 20px;</code></p>

		<h3 align="center">Options fields</h3>
		<p>Name an option to be displayed to the user. This option will be added in the select input field.</p>
		<p>Select wich type of style will be changed, class or individual element. If you used the web developer tools of yor browser
		to determine the elements you want to alter, an individual element is named by an "id", and class by "class". A class often has
		several elements. Remember to enter exactly the name, errors will be thrown if the names are incorrect and maybe the page functionality will be altered.</p>
		<p>Type the element id or class to be altered.</p>
		<p>Select the color of the background in the color selector tool.</p>
		<p>Select the color of the font in the color selector tool.</p>
		<p>Choose the transparency of the background, it will be dinamically updated over an image below.</p>
		<p>Choose the transparency of the text, it will be dinamically updated over an image below.</p>
		<p>The option button indicates if the edited option will be used by the plugin. No options will be added if they aren't active.</p>
		<p>Save yor changes clicking the blue button at the end of the page</p>
		<h3 align="center">Displaying the select drop down</h3>
		<p>There are currently two options, first one is to add the "Style selector widget" that this plugin creates to any sidebar.
		You can also configure a title for the widget.</p>
		<p>The second is via a shortcode. Place the shortcode <b>"[s_selector]"</b> anywhere to display the drop down menu</p>
		</div>
    <script>
        ss_pass_stored();
    </script>
</div>
<?php
//This function doesn't affect the display, is just for testing settings.
function prepareAdmOutput($ss_tab)
{
		$options = get_option('styleselector');
		$ss_fieldTypes = array("ss_disp_head", "ss_select_style", "ss_select_sheet_div", "ss_select_sheet_sel","ss_selected_theme", "ss_opt_name", "ss_theme_option_type","ss_element","ss_bg_colorPicker","ss_fn_colorPicker","ss_myRange","ss_myRangeFont" ,"ss_option");
		$ss_option_value = array("<select onchange='changeProps(this,".$ss_tab.")' id='widget_sselector_".$ss_tab."'><option value='Restore'>Restore</option>");
		$ss_option_values = array("Restore");
		for ($ss_tab = 1; $ss_tab < 6; $ss_tab++)
		{
			$ss_fieldId = $ss_fieldTypes[4]."_".$ss_tab;
			if (get_stylesheet() == $options[$ss_fieldId])
			{
				for ($ss_count = 1; $ss_count < 11; $ss_count++)
				{
					$tem_str = $options["ss_option"."_".$ss_tab."_".$ss_count];
					if ($options["ss_option"."_".$ss_tab."_".$ss_count] == 1)
					{
						$str = "'".$ss_tab."',";
						if (!in_array($options["ss_opt_name"."_".$ss_tab."_".$ss_count], $ss_option_values))
						{

							array_push($ss_option_value,"<option value='".$options["ss_opt_name"."_".$ss_tab."_".$ss_count]."'>".$options["ss_opt_name"."_".$ss_tab."_".$ss_count]."</option>");
							array_push($ss_option_values,$options["ss_opt_name"."_".$ss_tab."_".$ss_count]);						
						}
						for ($ss_fieldCount = 5; $ss_fieldCount < count($ss_fieldTypes); $ss_fieldCount++)
						{
							$ss_fieldId = $ss_fieldTypes[$ss_fieldCount]."_".$ss_tab."_".$ss_count;
							if ($ss_fieldCount == 5)
							{$str = $str."'".$options[$ss_fieldId]."'";}
							else{$str = $str.",'".$options[$ss_fieldId]."'";}
						}
						echo "<script>addOption(".$str.");</script>";
					}
				}
			}
		}
		foreach ($ss_option_value as $key=>$item){echo "$item\n";}
		echo "</select>
		<div><span style='font-size:15px;vertical-align:50%;cursor: pointer' title='Click to make the text smaller'>A</span>
		<span style='font-size:15px;vertical-align:50%;'>&#10138;</span>
		<span style='font-size:30px; vertical-align:25%;cursor:pointer' title='Click to make the text bigger'>A</span></div>";

}
 ?>