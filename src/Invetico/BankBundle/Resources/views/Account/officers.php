
	<form action="#" method="post">
	          <table width="100%" cellpadding="0" cellspacing="0" class="data-list" >
	            <thead>
	              <tr>
	                <th width="34" scope="col"><input type="checkbox" name="check-all-boxes" id="check-all-boxes" /></th>
	                <th width="136" scope="col">Full Name</th>
	                <th width="102" scope="col">Username</th>
					<th width="123" scope="col">Contact No</th>
	                <th width="109" scope="col">Email</th>
	                <th width="109" scope="col">Transactions</th>
	              </tr>
	            </thead>
	            <tbody>
					<?php foreach($this->collection as $user ):?>	
					<tr>
						<td width="34">
							<label>
								<input type="checkbox" class="check-box" name="checkbox" id="chk-<?php echo $user->getId();?>" value="<?php echo $user->getId();?>"/>
							</label>
						</td>
						<td ><?php echo $user->getFullName(); ?></td>
						<td ><?php echo $user->getUsername(); ?></td>
						<td ><?php echo $user->getContactnumber(); ?></td>
						<td ><?php echo $user->getEmail(); ?></td>
						<td ><a href="<?php echo $this->generate($user); ?>">View</a></td>
					</tr>
					<?php endforeach;?>
	            </tbody>
	          </table>
		<div id="action-btn-container">
			<a id="suspend-officers-btn" href="#" data-source-url="<?php echo $this->suspendOfficerUrl;?>">Suspend selected officers</a>
			<a id="delete-officers-btn"  href="#" data-source-url="<?php echo $this->deleteOfficerUrl;?>">Delete selected officers</a>
		</div>	          
	</form>