
		
		<form action="#" method="post">
	          
			  <table class="table" width="100%" cellpadding="0" cellspacing="0" id="data-list" >
	            <thead>
	              <tr>
	                <th width="34" scope="col"><input type="checkbox" name="check-all-boxes" id="check-all-boxes" /></th>
	                <th width="136" scope="col">Full Name</th>
	                <th width="102" scope="col">Username</th>
	                <th width="109" scope="col">Email</th>
	                <th width="109" scope="col">Address</th>
	                <th width="109" scope="col">Country</th>
	                <th width="40px" scope="col">Roles</th>
	                <th width="40px" scope="col">Action</th>
	              </tr>
	            </thead>
	            <tbody>
					<?php foreach($this->collection as $user ):?>	
					<tr>
						<td width="34">
							<label>
								<input type="checkbox" class="check-box" name="checkbox" id="checkbox" value="<?php echo $user->getId();?>"/>
							</label>
						</td>
						<td ><?php echo $user->getFullName(); ?></td>
						<td ><?php echo $user->getUsername(); ?></td>
						<td ><?php echo $user->getEmail(); ?></td>
						<td ><?php echo $user->getAddress(); ?></td>
						<td ><?php echo $user->getCountry(); ?></td>
						<td width="90"><a class="get_ajax" style="font-weight:bold" href="<?php echo $this->generateViewRolesUrl($user);?>">Change</a></td>
						<td width="40" style="text-align: right">
							<a class="btn btn-danger btn-content-delete btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete" data-delete-target="<?php echo $this->generateDeleteUrl($user);?>"><span class="glyphicon glyphicon-trash"></span></a>
						</td>
					</tr>
					<?php endforeach;?> 
	            </tbody>
				<tfooter>
		            <tr class="footer"> 
		            </tr>				
				</tfooter>
	          </table>
		    	<div class="pagination">
		            <?php echo $this->pagination; ?>
		        </div>			  
	    </form>