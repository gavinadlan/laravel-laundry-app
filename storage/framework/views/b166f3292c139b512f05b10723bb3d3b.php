<?php $__env->startSection('content'); ?>
    <div class="mb-6">
        <div class="flex items-center mb-2">
            <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center mr-3 shadow-lg">
                <i class="bi bi-graph-up text-white text-lg"></i>
            </div>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Orders Report</h1>
                <p class="text-gray-600 mt-1">Overview of your business performance</p>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <!-- Total Orders -->
        <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-xl p-6 border border-indigo-200 shadow-sm hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-indigo-600 mb-1">Total Orders</p>
                    <p class="text-3xl font-bold text-indigo-900"><?php echo e($totalOrders); ?></p>
                </div>
                <div class="w-14 h-14 bg-indigo-500 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="bi bi-cart text-white text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Revenue -->
        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-6 border border-green-200 shadow-sm hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-green-600 mb-1">Total Revenue</p>
                    <p class="text-3xl font-bold text-green-900">Rp <?php echo e(number_format($totalRevenue, 0, ',', '.')); ?></p>
                </div>
                <div class="w-14 h-14 bg-green-500 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="bi bi-cash-stack text-white text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Completed Orders -->
        <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-xl p-6 border border-emerald-200 shadow-sm hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-emerald-600 mb-1">Completed</p>
                    <p class="text-3xl font-bold text-emerald-900"><?php echo e($completedOrders); ?></p>
                </div>
                <div class="w-14 h-14 bg-emerald-500 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="bi bi-check-circle text-white text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Pending Orders -->
        <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-xl p-6 border border-yellow-200 shadow-sm hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-yellow-600 mb-1">Pending</p>
                    <p class="text-3xl font-bold text-yellow-900"><?php echo e($pendingOrders); ?></p>
                </div>
                <div class="w-14 h-14 bg-yellow-500 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="bi bi-clock text-white text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- In Progress Orders -->
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 border border-blue-200 shadow-sm hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-blue-600 mb-1">In Progress</p>
                    <p class="text-3xl font-bold text-blue-900"><?php echo e($inProgressOrders); ?></p>
                </div>
                <div class="w-14 h-14 bg-blue-500 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="bi bi-arrow-repeat text-white text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Delivered Orders -->
        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-6 border border-purple-200 shadow-sm hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-purple-600 mb-1">Delivered</p>
                    <p class="text-3xl font-bold text-purple-900"><?php echo e($deliveredOrders); ?></p>
                </div>
                <div class="w-14 h-14 bg-purple-500 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="bi bi-truck text-white text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Card -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-8">
        <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
            <i class="bi bi-bar-chart mr-2 text-indigo-600"></i>Order Status Summary
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="text-center p-6 bg-yellow-50 rounded-xl border border-yellow-200">
                <div class="w-12 h-12 bg-yellow-500 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="bi bi-clock text-white text-xl"></i>
                </div>
                <p class="text-2xl font-bold text-yellow-900"><?php echo e($pendingOrders); ?></p>
                <p class="text-sm text-yellow-600 mt-1">Pending</p>
                <?php if($totalOrders > 0): ?>
                    <p class="text-xs text-yellow-500 mt-2"><?php echo e(number_format(($pendingOrders / $totalOrders) * 100, 1)); ?>%</p>
                <?php endif; ?>
            </div>

            <div class="text-center p-6 bg-blue-50 rounded-xl border border-blue-200">
                <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="bi bi-arrow-repeat text-white text-xl"></i>
                </div>
                <p class="text-2xl font-bold text-blue-900"><?php echo e($inProgressOrders); ?></p>
                <p class="text-sm text-blue-600 mt-1">In Progress</p>
                <?php if($totalOrders > 0): ?>
                    <p class="text-xs text-blue-500 mt-2"><?php echo e(number_format(($inProgressOrders / $totalOrders) * 100, 1)); ?>%</p>
                <?php endif; ?>
            </div>

            <div class="text-center p-6 bg-green-50 rounded-xl border border-green-200">
                <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="bi bi-check-circle text-white text-xl"></i>
                </div>
                <p class="text-2xl font-bold text-green-900"><?php echo e($completedOrders); ?></p>
                <p class="text-sm text-green-600 mt-1">Completed</p>
                <?php if($totalOrders > 0): ?>
                    <p class="text-xs text-green-500 mt-2"><?php echo e(number_format(($completedOrders / $totalOrders) * 100, 1)); ?>%</p>
                <?php endif; ?>
            </div>

            <div class="text-center p-6 bg-purple-50 rounded-xl border border-purple-200">
                <div class="w-12 h-12 bg-purple-500 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="bi bi-truck text-white text-xl"></i>
                </div>
                <p class="text-2xl font-bold text-purple-900"><?php echo e($deliveredOrders); ?></p>
                <p class="text-sm text-purple-600 mt-1">Delivered</p>
                <?php if($totalOrders > 0): ?>
                    <p class="text-xs text-purple-500 mt-2"><?php echo e(number_format(($deliveredOrders / $totalOrders) * 100, 1)); ?>%</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/gavinadlan/Documents/code/laundry_app/resources/views/reports/orders.blade.php ENDPATH**/ ?>