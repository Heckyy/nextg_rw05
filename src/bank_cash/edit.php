<?php
	class edit_bank_cash{
		
		function edit_view($db,$e,$code){

			$view=base64_decode($code);
			$view_bank_cash=$db->select('tb_bank_cash','code_bank_cash="'.$view.'"','id_bank_cash','DESC');

			if(mysqli_num_rows($view_bank_cash)>0 && $_SESSION['bank_cash_edit']==1){
				$v=mysqli_fetch_assoc($view_bank_cash);

				$access=$db->select('tb_access_bank INNER JOIN tb_employee ON tb_access_bank.id_employee=tb_employee.id_employee','tb_access_bank.id_bank_cash="'.$v['id_bank_cash'].'"','tb_access_bank.id_access_bank','DESC');

				$employee=$db->select('tb_employee','id_employee','name','ASC');
?>
				<script src="<?php echo $e; ?>/src/bank_cash/js/js_proses.js"></script>
				<div class="app-card-header p-3 main-content container-fluid">
					<div class="row justify-content-between align-items-center line">
						<div class="col-auto">
							<h6 class="app-card-title">
								Bank / Cash
							</h6>
						</div>
					</div>
				</div>

				 <div class="app-card-body pb-3 main-content container-fluid">
					<form method="POST" id="edit">
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Code
							</div>
							<div class="col-sm-2 col-lg-2">
								<input type="text" name="code_bank_cash" id="code_bank_cash" minlength="3" maxlength="3" class="form-control square" value="<?php echo $view; ?>" required="required" disabled>
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Bank / Cash
							</div>
							<div class="col-sm-2 col-lg-2">
								<input type="text" name="bank_cash" id="bank_cash" class="form-control square" value="<?php echo $v['bank_cash']; ?>" required="required">
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								No. Rek
							</div>
							<div class="col-sm-2 col-lg-2">
								<input type="text" name="account_number" id="account_number" class="form-control square" value="<?php echo $v['account_number']; ?>">
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Note
							</div>
							<div class="col-sm-5 col-lg-5">
								<textarea  name="note" id="note" class="form-control square textarea-edit"><?php echo $v['note']; ?></textarea>
							</div>
						</div>
						<div class="space_line row">
							<div class="col-sm-2 col-lg-2">
								Access
							</div>
							<div class="col-sm-5 col-lg-5">
								<select id="access" name="access" class="form-control square bg-white" required="required">
									<option value="">Select</option>
									<?php
										foreach ($employee as $key => $em) {
											$cek=$db->select('tb_access_bank','id_bank_cash="'.$v['id_bank_cash'].'" && id_employee="'.$em['id_employee'].'"','id_access_bank','DESC');
											if(mysqli_num_rows($cek)==0){
									?>
												<option value="<?php echo $em['id_employee']; ?>"><?php echo $em['name']; ?></option>
									<?php
											}
										}
									?>
								</select>
							</div>
						</div>
						<div class="space_line row">
							<div class="col-lg-12">
								<button type="submit" id="btn" class="btn btn-sm btn-success btn-custom">Save</button>
							</div>
						</div>
					</form>
					<table class="table mb-0">
						<thead>
							<tr>
								<td width="50px" align="center">No</td>
								<td>Name</td>
								<td width="100px" align="center">Action</td>
							</tr>
						</thead>
						<tbody>
							<?php
								$no=1;
								foreach ($access as $key => $a) {
									$acak=str_replace("=", "", base64_encode($a['id_access_bank']));
							?>
									<tr>
										<td align="center"><?php echo $no; ?>.</td>
										<td><?php echo $a['name']; ?></td>
										<td align="center">
											<a href="#" onclick="hapus('<?php echo $acak; ?>')">
												<i class="bi bi-trash"></i>
											</a>
										</td>
									</tr>
							<?php
								$no++;
								}
							?>
						</tbody>
					</table>
				</div>
<?php
			}else{
?>
				<script type="text/javascript">
					document.location.href=localStorage.getItem('data_link')+"/bank-cash";
				</script>
<?php
			}
		}

	}
?>