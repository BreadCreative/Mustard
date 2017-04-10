<table class="form-table">
	<tr>
		<th>Indicator shortcode</th>
		<td>
			<code>
				[mbhi location="your location name"]
			</code>
			<div class="p-t-2">
				<span class="extra-info">
					Use this shortcode to display the open/closed indicator anywhere in your posts or on your pages.
				</span>
			</div>
		</td>
	</tr>
	<tr>
		<th>Indicator shortcode for themes</th>
		<td>
			<code>
				&lt;?php
				echo do_shortcode('[mbhi location="your location name"]');
				?&gt;
			</code>
			<div class="p-t-2">
				<span class="extra-info">
					This code allows you to use the indicator directly in your theme.
				</span>
			</div>
		</td>
	</tr>
	<tr>
		<th>Business hours shortcode</th>
		<td>
			<code>
				[mbhi_hours location="your location name"]
			</code>
			<div class="p-t-2">
				<span class="extra-info">
					Use this shortcode to display your opening hours anywhere in your posts or on your pages.
				</span>
			</div>
		</td>
	</tr>
	<tr>
		<th>Business hours shortcode for themes</th>
		<td>
			<code>
				&lt;?php
				echo do_shortcode('[mbhi_hours location="your location name"]');
				?&gt;
			</code>
			<div class="p-t-2">
				<span class="extra-info">
					This code allows you to show your opening times directly in your theme.
				</span>
			</div>
		</td>
	</tr>
	<tr>
		<th>'if open' shortcode</th>
		<td>
			<code>
				[mbhi_ifopen location="your location name"]
				   Your content...
				[/mbhi_ifopen]
			</code>
			<div class="p-t-2">
				<span class="extra-info">
					Use this shortcode to display something only when your business is currently open.
				</span>
			</div>
		</td>
	</tr>
	<tr>
		<th>'if closed' shortcode</th>
		<td>
			<code>
				[mbhi_ifclosed location="your location name"]
				   Your content...
				[/mbhi_ifclosed]
			</code>
			<div class="p-t-2">
				<span class="extra-info">
					Use this shortcode to display something only when your business is currently closed.
				</span>
			</div>
		</td>
	</tr>
	<tr>
		<th></th>
		<td>
			<a href="https://businesshourplugin.maartenbelmans.com/docs/free-documentation/usage/all-shortcodes/" target="_blank">Read the documentation</a> to find out all available options for shortcodes.
		</td>
	</tr>
</table>