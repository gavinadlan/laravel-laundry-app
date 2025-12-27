<?php $__env->startSection('content'); ?>
    <h1>Create Service</h1>
    <form action="<?php echo e(route('services.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" id="name" class="form-control" value="<?php echo e(old('name')); ?>" required>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" step="0.01" name="price" id="price" class="form-control" value="<?php echo e(old('price')); ?>" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control"><?php echo e(old('description')); ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="<?php echo e(route('services.index')); ?>" class="btn btn-secondary">Cancel</a>
    </form>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/gavinadlan/Documents/code/laundry_app/resources/views/services/create.blade.php ENDPATH**/ ?>