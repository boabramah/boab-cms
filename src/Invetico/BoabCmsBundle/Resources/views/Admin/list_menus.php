<div id="AjaxResult"></div>
<form>
	<input type="hidden" id="table_sort_url" name="table_sort_url" value="<?php echo $this->tableSortUrl;?>">
	<table width="100%" class="sort-table" id="data-list">
		<thead>
			<tr>
				<th style="width:20px"></th>
				<th >Title</th>
				<th >Route Name</th>
				<th >Path</th>
				<th colspan="2" width="50px">Action</th>
			</tr>
		</thead>
		<tbody>
			<?php echo $this->menuList;?>
		</tbody>
		<tfoot>
			<tr class="footer">
				<td colspan="2">
					<a data-delete-url="<?php echo $this->deleteSelectedCheckBoxUrl;?>" href="<?php echo $this->deleteSelectedCheckBoxUrl;?>" id="deleteSlectedCheckBox" class="delete_inline">Delete all</a>
				</td>
				<td colspan="6" align="right">           
					<div class="pagination"><?php echo $this->pagination; ?></div>       
				</td>
			</tr>
		</tfoot>
	</table>
</form>