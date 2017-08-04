				<div id="form-meta-data">
					<span id="AjaxResult"></span>

						<table id="meta" align="right" cellspacing="5" width="100%">
							<tr>
								<td>
									<form action="<?php echo $this->catUrl;?>" name="">
										<label>Show</label>
										<select name="pagelimit" id="pagelimit">
											<option value="10"> 10 </option>
											<option value="50"> 50 </option>
											<option value="100"> 100 </option>
											<option value="150"> 150 </option>
										</select>
									</form>
								</td>
								<td class="cat-option-select">
									<form action="<?php echo $this->catUrl;?>" name="">
										<label>Filter content by type</label>
										<select name="catOptionSelect" id="catOptionSelect">
											<option value="0"> All </option>
											<?php echo $this->contentTypesOptionsList;?>
										</select>
									</form>
								</td>
							</tr>
						</table>

					<div style="clear:both"></div>
				</div>
