<section class="title">
	<h4><?php echo lang('ug:users'); ?></h4>
</section>

<section class="item">
<div class="content">

		<?php if ($users['total'] > 0): ?>
		
			<table class="table" cellpadding="0" cellspacing="0">
				<thead>
					<tr>
						<th><?php echo lang('ug:id'); ?></th>
						<th><?php echo lang('ug:first_name'); ?></th>
						<th><?php echo lang('ug:last_name'); ?></th>
						<th><?php echo lang('ug:email'); ?></th>
						<th><?php echo lang('ug:phone'); ?></th>
						<th><?php echo lang('ug:age'); ?></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($users['entries'] as $user): ?>
					<tr>
						<td><?php echo $user['id']; ?></td>
						<td><?php echo $user['first_name']; ?></td>
						<td><?php echo $user['last_name']; ?></td>
						<td><?php echo $user['email']; ?></td>
						<td><?php echo $user['phone']; ?></td>
						<td><?php echo $user['age']; ?></td>
						<td class="actions">
							<?php echo anchor('admin/usergroup/edit/' . $user['id'], lang('global:edit'), 'class="button edit"'); ?>
							<?php echo anchor('admin/usergroup/delete/' . $user['id'], lang('global:delete'), array('class' => 'confirm button delete')); ?>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			
			<?php echo $users['pagination']; ?>
			
		<?php else: ?>
			<div class="no_data"><?php echo lang('ug:no_users'); ?></div>
		<?php endif;?>
	
</div>
</section>

