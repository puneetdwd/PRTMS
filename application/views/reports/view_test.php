<!--Popup Start-->
<?php $category = $test['chamber_category']; ?>

    <div class="modal-dialog modal-lg" >
        <div class="modal-content" >
            <div class="modal-body" id='view_comp'> 
				<style>
					.table.table-light>tbody>tr>td {
							border: 0;
							border-bottom: 0px solid #F2F5F8;
							color: #8896a0;
							vertical-align: middle;
							color:#000;
							width:25%
					}
					.modal .modal-header {
						border-bottom: 0px solid #EFEFEF;
					}
				</style>
			
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<h3 class="modal-title text-center" style='text-align:center'><b>View Test Details</b></h3>
				</div>
				<hr />
				<table class="table table-hover table-light" border=0 style='border-collapse:collapse;width:100%'>
								<tr>
									<td><b>Start Date:</b></td>
									<td><?php echo date('jS M, Y h:i A', strtotime($test['start_date'])); ?></td>
									<td><b>End Date:</b></td>
									<td><?php echo date('jS M, Y h:i A', strtotime($test['end_date'])); ?>
										<?php if(!empty($test['extended_hrs'])) { ?>
											<small>(Extended by <?php echo $test['extended_hrs'].' hours';?>)</small>
										<?php } ?></td>
									
								</tr>
								<tr>
									<td><b>Observation Frequency:</b></td>
									<td><?php echo $test['observation_frequency'].' hrs'; ?></td>
									<td><b>No of Samples:</b></td>
									<td><?php echo $test['samples']; ?></td>                                
								</tr>
								<!--<tr>
									<td><b>LOT/ASN NO:</b></td>
									<td><?php echo $test['lot_no']; ?></td>
									<td><b>Chamber Category:</b></td>
									<td><?php echo $test['chamber_category']; ?></td>
									
								</tr-->
				</table>
							
				<hr />
				   
				<table class="table table-hover table-light" border=0 style='border-collapse:collapse;width:100%'>
								
								<tr>
									<td><b>LOT/ASN NO:</b></td>
									<td><?php echo $test['lot_no']; ?></td>
									<td><b>Chamber Category:</b></td>
									<td><?php echo $test['chamber_category']; ?></td>
									
								</tr>
								<tr>
									<td><b>Chamber Spec:</b></td>
									<td><?php echo $test['observation_frequency'].' hrs'; ?></td>
									<td><b>No of Samples:</b></td>
									<td><?php echo $test['chamber_spec']; ?></td>                                
								</tr>
				</table>
							
				<hr />
				   
				<table class="table table-hover table-light" border=0 style='border-collapse:collapse;width:100%'>
								
								<tr>
									<td><b>Product Name:</b></td>
									<td><?php echo $test['product_name']; ?></td>
									<td><b>Supplier Name:</b></td>
									<td>  <?php echo $test['part_num']; ?></td>                                
								</tr>
								<tr>
									<td><b>Part Name:</b></td>
									<td> <?php echo $test['part_name']; ?></td>
									<td><b>Part No:</b></td>
									<td><?php echo $test['chamber_category']; ?></td>
									
								</tr>
				</table>
					
				<hr />
				<table class="table table-hover table-light" border=0 style='border-collapse:collapse;width:100%'>
								
								<tr>
									<td><b>Test Name:</b></td>
									<td><?php echo $test['test_name']; ?></td>
									<td><b>Test Duration:</b></td>
									<td><?php echo $test['duration'].' hrs'; ?></td>
									
								</tr>
								<tr>
									<td><b>Test Method:</b></td>
									<td> <?php echo $test['test_method']; ?></td>
									<td><b>Test Judgement:</b></td>
									<td>  <?php echo $test['test_judgement']; ?></td>                                
								</tr>
				</table>
					
				<hr />
				
				<?php if(!empty($test['retest_remark'])){ ?>
				<table class="table table-hover table-light" border=0 style='border-collapse:collapse;width:100%'>
								
								<tr>
									<td><b>Retest Remark:</b></td>
									<td><?php echo $test['retest_remark']; ?></td>
									
								</tr>
								
				</table>
				<hr />
				<?php } ?>
					
				
				
				<?php if(!empty($test['skip_remark'])){ ?>
				<table class="table table-hover table-light" border=0 style='border-collapse:collapse;width:100%'>                
								<tr>
									<td><b>Skip Test Remark:</b></td>
									<td> <?php echo $test['skip_remark']; ?></td>                                
								</tr>							
				</table>
				<hr />
				<?php } ?>
				
				<p><b>Observations :</b></p>
				
			    <div class="table-responsive">
					<table class="table table-bordered table-condensed" border="1" style='border-collapse:collapse'>
						<tr>
							<td rowspan="4" class="merged-col" style="width:0px;">Plan</td>
							<td style="width:100px;">Day</td>

							<?php for($i=0; $i<$test['no_of_observations']; $i++) { ?>
								<td colspan="<?php echo $test['samples']; ?>" class="text-center"><?php echo $i; ?></td>
							<?php } ?>
						</tr>
						<tr>
							<td>Samples</td>
							<?php foreach($observations['sample'] as $ob) { ?>
								<td><?php echo $ob; ?></td>
							<?php } ?>
						</tr>
						<tr>
							<td>Date</td>
							<?php foreach($observations['observation_at'] as $ob) { ?>
								<td><?php echo $ob; ?></td>
							<?php } ?>
						</tr>
						<tr>
							<td class="merged-col">Result</td>

							<?php foreach($observations['observation_result'] as $ob) { ?>
								<td><?php echo $ob; ?></td>
							<?php } ?>
						</tr>

						<?php if($category == 'Electrical') { ?>
							<tr>
								<td class="merged-col">Check Items</td>
								<td>Unit</td>

								<?php foreach($observations['check_items'] as $ob) { ?>
									<td><?php echo $ob; ?></td>
								<?php } ?>
							</tr>

							<tr>
								<td class="merged-col">Appearance</td>
								<td>Visual</td>

								<?php foreach($observations['appearance'] as $ob) { ?>
									<td><?php echo $ob; ?></td>
								<?php } ?>
							</tr>

							<tr>
								<td class="merged-col">Current</td>
								<td>Amp</td>

								<?php foreach($observations['current'] as $ob) { ?>
									<td><?php echo $ob; ?></td>
								<?php } ?>
							</tr>

							<tr>
								<td rowspan="2" class="merged-col">Voltage</td>
								<td>Set Volt</td>

								<?php foreach($observations['set_volt'] as $ob) { ?>
									<td><?php echo $test['set_volt']; ?></td>
								<?php } ?>
							</tr>
							<tr>
								<td>Test Volt</td>

								<?php foreach($observations['act_volt'] as $ob) { ?>
									<td><?php echo $ob; ?></td>
								<?php } ?>
							</tr>

							<tr>
								<td class="merged-col">Power/Wattage</td>
								<td>Watt</td>

								<?php foreach($observations['power_watt'] as $ob) { ?>
									<td><?php echo $ob; ?></td>
								<?php } ?>
							</tr>
						<?php } ?>

						<?php if($category == 'Environmental' || $category == 'Heat & Humid') { ?>
							<tr>
								<td rowspan="2" class="merged-col">Display Temperature (&#8451;)</td>
								<td>Set</td>

								<?php foreach($observations['display_temp_set'] as $ob) { ?>
									<td><?php echo $test['display_temp_set']; ?></td>
								<?php } ?>
							</tr>
							<tr>
								<td>Actual</td>

								<?php foreach($observations['display_temp_act'] as $ob) { ?>
									<td><?php echo $ob; ?></td>
								<?php } ?>
							</tr>
							<tr>
								<td rowspan="2" class="merged-col">Humidity (%RH)</td>
								<td>Set</td>

								<?php foreach($observations['humidity_set'] as $ob) { ?>
									<td><?php echo $test['humidity_set']; ?></td>
								<?php } ?>
							</tr>
							<tr>
								<td>Actual</td>

								<?php foreach($observations['humidity_act'] as $ob) { ?>
									<td><?php echo $ob; ?></td>
								<?php } ?>
							</tr>

							<tr>
								<td class="merged-col">Visual</td>
								<td>Test Volt</td>

								<?php foreach($observations['act_volt'] as $ob) { ?>
									<td><?php echo $ob; ?></td>
								<?php } ?>
							</tr>
						<?php } ?>

						<?php if($category == 'Salt Spray') { ?>
							<tr>
								<td class="merged-col">Check Points</td>
								<td>Unit</td>

								<?php foreach($observations['check_items'] as $ob) { ?>
									<td><?php echo $ob; ?></td>
								<?php } ?>
							</tr>

							<tr>
								<td rowspan="2" class="merged-col">Display Temperature (&#8451;)</td>
								<td>Set</td>

								<?php foreach($observations['display_temp_set'] as $ob) { ?>
									<td><?php echo $test['display_temp_set']; ?></td>
								<?php } ?>
							</tr>
							<tr>
								<td>Actual</td>

								<?php foreach($observations['display_temp_act'] as $ob) { ?>
									<td><?php echo $ob; ?></td>
								<?php } ?>
							</tr>

							<tr>
								<td rowspan="2" class="merged-col">Pressure</td>
								<td>Set</td>

								<?php foreach($observations['pressure_set'] as $ob) { ?>
									<td><?php echo $test['pressure_set']; ?></td>
								<?php } ?>
							</tr>
							<tr>
								<td>Actual</td>

								<?php foreach($observations['pressure_act'] as $ob) { ?>
									<td><?php echo $ob; ?></td>
								<?php } ?>
							</tr>

							<tr>
								<td class="merged-col">PH</td>
								<td>Actual PH</td>

								<?php foreach($observations['ph_act'] as $ob) { ?>
									<td><?php echo $ob; ?></td>
								<?php } ?>
							</tr>

							<tr>
								<td class="merged-col">Fog Collection</td>
								<td>Actual Fog</td>

								<?php foreach($observations['fog'] as $ob) { ?>
									<td><?php echo $ob; ?></td>
								<?php } ?>
							</tr>

							<tr>
								<td class="merged-col">Salt Water Level</td>
								<td>Actual</td>

								<?php foreach($observations['salt_water_level'] as $ob) { ?>
									<td><?php echo $ob; ?></td>
								<?php } ?>
							</tr>

							<tr>
								<td rowspan="2" class="merged-col">Voltage</td>
								<td>Set Volt</td>

								<?php foreach($observations['set_volt'] as $ob) { ?>
									<td><?php echo $test['set_volt']; ?></td>
								<?php } ?>
							</tr>
							<tr>
								<td>Test Volt</td>

								<?php foreach($observations['act_volt'] as $ob) { ?>
									<td><?php echo $ob; ?></td>
								<?php } ?>
							</tr>
						<?php } ?>

						<?php if($category != 'Salt Spray') { ?>
							<?php if($category == 'Electrical') { ?>
								<tr>
									<td class="merged-col">Torque</td>
									<td>RPM</td>

									<?php foreach($observations['torque_rpm'] as $ob) { ?>
										<td><?php echo $ob; ?></td>
									<?php } ?>
								</tr>
							<?php } else { ?>
								<tr>
									<td class="merged-col">Rust</td>
									<td>Visual</td>

									<?php foreach($observations['rust'] as $ob) { ?>
										<td><?php echo $ob; ?></td>
									<?php } ?>
								</tr>
							<?php } ?>

							<tr>
								<td class="merged-col">Colour</td>
								<td>&#916;E</td>

								<?php foreach($observations['colour'] as $ob) { ?>
									<td><?php echo $ob; ?></td>
								<?php } ?>
							</tr>
							<tr>
								<td class="merged-col">Crack/Damage</td>
								<td>Visual</td>

								<?php foreach($observations['crack'] as $ob) { ?>
									<td><?php echo $ob; ?></td>
								<?php } ?>
							</tr>
							<tr>
								<td class="merged-col">Adhesion Peel-Off</td>
								<td>Visual</td>

								<?php foreach($observations['adhesion'] as $ob) { ?>
									<td><?php echo $ob; ?></td>
								<?php } ?>
							</tr>
						<?php } else { ?>
							<tr>
								<td class="merged-col">Visual</td>
								<td>Test Volt</td>

								<?php foreach($observations['act_volt'] as $ob) { ?>
									<td><?php echo $ob; ?></td>
								<?php } ?>
							</tr>
							<tr>
								<td class="merged-col">Rust</td>
								<td>White/Red</td>

								<?php foreach($observations['rust'] as $ob) { ?>
									<td><?php echo $ob; ?></td>
								<?php } ?>
							</tr>
							<tr>
								<td class="merged-col">Adhesion Peel-Off</td>
								<td>Visual</td>

								<?php foreach($observations['adhesion'] as $ob) { ?>
									<td><?php echo $ob; ?></td>
								<?php } ?>
							</tr>
						<?php } ?>

						<tr>
							<td colspan="2" class="merged-col">Assistant Name</td>

							<?php foreach($observations['assistant_name'] as $ob) { ?>
								<td><?php echo $ob; ?></td>
							<?php } ?>
						</tr>
						
					</table>
				</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="button white" data-dismiss="modal">Close</button>
				<a class="button" onclick="printPage('view_comp');" href="javascript:void(0);">
					<i class="fa fa-print"></i> Print
				</a>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->

<!--Popup End-->