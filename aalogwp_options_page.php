<?php

$aalog_cookie = get_option('aalog_cookie');

$bLogcookie = isset($_COOKIE[$aalog_cookie]);

$logfileName = get_option('aalog_filename');
?>
<style>
	.logoptions {border: 1px solid #C7D4DB; border-radius: 5px; padding: 5px;}
	.loglabel {width: 200px; display: inline-block;}
	.logdata {color: #5F7C8C; font-weight: bold;}
	.lognotes {font-style: italic; color: #BABCBC;}
</style>
<div class="wrap">
	<?php screen_icon(); ?>
	<h2>aaLog Options</h2>

	<p>This plugin is strictly for developers. It allows them to put logging calls in the code. 
	Documentation for the logging calls can be found at:<br>
	<a href="http://www.notoriouswebmaster.com/2013/07/01/aalog-a-logging-class-for-php/" target="_blank">
		aaLog: A Logging Class for PHP
	</a>.</p>

	<p class="logoptions">
		<span class="loglabel">Cookie name:</span>
			<span class="logdata"><?php echo $aalog_cookie; ?></span><br>

		<span class="loglabel">Logfile name:</span>
			<span class="logdata"><?php echo $logfileName . '.log'; ?></span><br>

		<span class="loglabel">Logging is currently:</span>
			<span class="logdata"><?php echo $bLogcookie ? 'ON' : 'OFF' ?></span>
	</p>

	<form action="options-general.php?page=aalogwp_settings" method="post">
		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row">
						Log file name<br>
						<span class="lognotes">(plugin appends .log)</span>
					</th>
					<td>
						<input type="text" name="logfilename" value="<?php echo $logfileName; ?>" >
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">Logging</th>
					<td>
						<fieldset>
							<input type="radio" name="setcookie" value="set" <?php echo $bLogcookie ? 'checked' : '' ?>> On<br>
							<input type="radio" name="setcookie" value="unset" <?php echo !$bLogcookie ? 'checked' : '' ?>> Off							
						</fieldset>
					</td>
				</tr>
			</tbody>
		</table>
		<p class="submit">
			<input type="submit" value="Save Changes" class="button button-primary" id="submit" name="submit">
			<input type="submit" value="Regenerate Cookie" class="button button-primary" name="regencookie">
			<input type="submit" value="Regenerate Filename" class="button button-primary" name="regenfilename">
		</p>
	</form>

</div>