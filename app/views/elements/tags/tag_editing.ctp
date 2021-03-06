<?php 
// This element has $available_tags and (optionally) $selected_tags passed into it

// Counters CakePHP's variable-renaming weirdness
if (! isset($available_tags)) {
	$available_tags = isset($availableTags) ? $availableTags : array();
}
if (! isset($selected_tags)) {
	$selected_tags = isset($selectedTags) ? $selectedTags : array();
}
if (! isset($tree)) {
	$tree =& ClassRegistry::init('Tree', 'helper'); 	
}
?>

<div class="input">
	<table id="tag_editing">
		<thead>
			<tr>
				<th>
					<label style="float: left;">
						Tags
					</label>
					<span>Available</span>
				</th>
				<td class="tween_spacer">
					&nbsp;
				</td>
				<th>
					<span>Selected</span>
				</th>
			</tr>
		</thead>
		<tfoot></tfoot>
		<tbody>
			<tr>
				<td id="available_tags" class="fake_input">
					<?php echo $tree->show('Tag/name', $available_tags, true); ?>
				</td>
				<td class="tween_spacer">
					<?php echo $this->Html->image('icons/arrow_right_gray.png', array('title' => "Selected tags appear over here.")); ?>
				</td>
				<td id="selected_tags" class="fake_input">
					<ul class="tag_editing"></ul>
				</td>
			</tr>
			<tr>
				<td>
					&nbsp;<br />
					<label style="height: 20px;">
						Additional Tags
						<span id="tag_autosuggest_loading" style="display: none;">
							<img src="/img/loading2.gif" alt="Working..." title="Working..." style="vertical-align:top;" />
						</span>
					</label>
					<?php 
						echo $this->Form->input('custom_tags', array(
							'label' => false, 
							'style' => 'margin-right: 5px; width: 100%; display: block;', 
							'between' => '<div class="footnote">Write out tags, separated by commas</div>',
							'id' => 'custom_tag_input'
						)); 
					?>
					<div id="tag_autocomplete_choices"></div>
					<script type="text/javascript">
						new Ajax.Autocompleter("custom_tag_input", "tag_autocomplete_choices", "/tags/autocomplete", {
							paramName: 'string_to_complete',
							minChars: 1,
							frequency: 0.2,
							indicator: 'tag_autosuggest_loading',
							tokens: ',',
							parameters: 'model=<?php echo Inflector::classify($this->params['controller'])?>'
						});
					</script>
				</td>
				<td class="tween_spacer">
					&nbsp;
				</td>
				<td style="vertical-align: top;">
					<img src="/img/icons/help.png" alt="Help" title="Help" onclick="Effect.toggle('taggy_draggy_help', 'appear')" class="help_toggler" style="float: right; margin-left: 5px;" />
					<div id="taggy_draggy_help" class="footnote" style="display: none;">
						<ul style="margin: 0px; padding-left: 15px;">
							<li>Move your cursor over tags that you want to add and click the [+] button that pops up to add them.</li>
							<li>After a tag has been added, you can click on the [-] button next to it to remove it.</li> 
							<li>Some tags can be clicked on to expand them and see related tags.</li>
							<li>Some tags, like the ones that are just headers for larger categories, can't be selected.</li>
						</ul>
					</div>
				</td>
			</tr>
		</tbody>
	</table>
</div>

<?php if (isset($selected_tags)): ?>
	<script type="text/javascript">
		<?php foreach($selected_tags as $tag): ?>
			<?php // remove "true || " if listed/unlisted tag support is implemented ?>
			<?php if (true || $tag['listed']): ?>
				selectTag('tag_<?php echo $tag['id'] ?>');
			<?php else: ?>
				selectUnlistedTag('<?php echo $tag['id'] ?>', "<?php echo str_replace('"', '&quot;', $tag['name']) ?>");
			<?php endif; ?>
		<?php endforeach; ?>
	</script>
<?php endif; ?>