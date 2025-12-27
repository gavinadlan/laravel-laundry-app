<?php $__env->startSection('content'); ?>
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-3xl font-bold text-gray-900 mb-2 flex items-center">
                <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center mr-3 shadow-lg">
                    <i class="bi bi-cart-check text-white text-lg"></i>
                </div>
                Orders
            </h1>
            <p class="text-gray-600 mt-1">Manage and track all your laundry orders</p>
        </div>
        <a href="<?php echo e(route('orders.create')); ?>" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
            <i class="bi bi-plus-circle mr-2 text-lg"></i>
            New Order
        </a>
    </div>
    
    <?php if($orders->count() > 0): ?>
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-4 border border-blue-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-blue-600">Total Orders</p>
                        <p class="text-2xl font-bold text-blue-900"><?php echo e($orders->total()); ?></p>
                    </div>
                    <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center">
                        <i class="bi bi-cart text-white text-xl"></i>
                    </div>
                </div>
            </div>
            <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-xl p-4 border border-yellow-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-yellow-600">Pending</p>
                        <p class="text-2xl font-bold text-yellow-900"><?php echo e($orders->where('status', 'pending')->count()); ?></p>
                    </div>
                    <div class="w-12 h-12 bg-yellow-500 rounded-lg flex items-center justify-center">
                        <i class="bi bi-clock text-white text-xl"></i>
                    </div>
                </div>
            </div>
            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-4 border border-green-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-green-600">Completed</p>
                        <p class="text-2xl font-bold text-green-900"><?php echo e($orders->where('status', 'completed')->count()); ?></p>
                    </div>
                    <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center">
                        <i class="bi bi-check-circle text-white text-xl"></i>
                    </div>
                </div>
            </div>
            <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-4 border border-purple-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-purple-600">In Progress</p>
                        <p class="text-2xl font-bold text-purple-900"><?php echo e($orders->where('status', 'in_progress')->count()); ?></p>
                    </div>
                    <div class="w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center">
                        <i class="bi bi-arrow-repeat text-white text-xl"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Payment Status Summary -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-4 border border-green-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-green-600">Paid Orders</p>
                        <p class="text-2xl font-bold text-green-900"><?php echo e($orders->filter(fn($o) => $o->payment)->count()); ?></p>
                    </div>
                    <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center">
                        <i class="bi bi-check-circle text-white text-xl"></i>
                    </div>
                </div>
            </div>
            <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-xl p-4 border border-red-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-red-600">Unpaid Orders</p>
                        <p class="text-2xl font-bold text-red-900"><?php echo e($orders->filter(fn($o) => !$o->payment)->count()); ?></p>
                    </div>
                    <div class="w-12 h-12 bg-red-500 rounded-lg flex items-center justify-center">
                        <i class="bi bi-exclamation-circle text-white text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-sm">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-indigo-600 to-purple-600">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                            <i class="bi bi-hash mr-2"></i>ID
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                            <i class="bi bi-person mr-2"></i>Customer
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                            <i class="bi bi-calendar-event mr-2"></i>Order Date
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                            <i class="bi bi-calendar-check mr-2"></i>Delivery Date
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                            <i class="bi bi-info-circle mr-2"></i>Status
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                            <i class="bi bi-currency-dollar mr-2"></i>Total
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                            <i class="bi bi-gear mr-2"></i>Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-bold text-indigo-600">#<?php echo e($order->id); ?></span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center mr-3">
                                        <i class="bi bi-person-fill text-indigo-600"></i>
                                    </div>
                                    <div>
                                        <div class="text-sm font-semibold text-gray-900"><?php echo e($order->customer->name); ?></div>
                                        <?php if($order->customer->phone): ?>
                                            <div class="text-xs text-gray-500"><?php echo e($order->customer->phone); ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    <i class="bi bi-calendar3 text-gray-400 mr-2"></i>
                                    <?php echo e($order->order_date ? date('M d, Y', strtotime($order->order_date)) : '-'); ?>

                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    <i class="bi bi-calendar-check text-gray-400 mr-2"></i>
                                    <?php echo e($order->delivery_date ? date('M d, Y', strtotime($order->delivery_date)) : '-'); ?>

                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php
                                    $statusConfig = [
                                        'pending' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'icon' => 'clock'],
                                        'in_progress' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800', 'icon' => 'arrow-repeat'],
                                        'completed' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'icon' => 'check-circle'],
                                        'delivered' => ['bg' => 'bg-purple-100', 'text' => 'text-purple-800', 'icon' => 'truck']
                                    ];
                                    $config = $statusConfig[$order->status] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-800', 'icon' => 'circle'];
                                ?>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold <?php echo e($config['bg']); ?> <?php echo e($config['text']); ?>">
                                    <i class="bi bi-<?php echo e($config['icon']); ?> mr-1.5"></i>
                                    <?php echo e(ucfirst(str_replace('_', ' ', $order->status))); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex flex-col">
                                    <div class="text-sm font-bold text-green-600">
                                        Rp <?php echo e(number_format($order->total, 0, ',', '.')); ?>

                                    </div>
                                    <?php if($order->payment): ?>
                                        <span class="mt-1 inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-green-100 text-green-800">
                                            <i class="bi bi-check-circle mr-1"></i>Paid
                                        </span>
                                    <?php else: ?>
                                        <span class="mt-1 inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-yellow-100 text-yellow-800">
                                            <i class="bi bi-exclamation-circle mr-1"></i>Unpaid
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <a href="<?php echo e(route('orders.show', $order)); ?>" class="inline-flex items-center px-3 py-1.5 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors duration-200" title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="<?php echo e(route('orders.edit', $order)); ?>" class="inline-flex items-center px-3 py-1.5 bg-yellow-100 text-yellow-700 rounded-lg hover:bg-yellow-200 transition-colors duration-200" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <?php if(!$order->payment): ?>
                                        <a href="<?php echo e(route('payments.create')); ?>?order_id=<?php echo e($order->id); ?>" class="inline-flex items-center px-3 py-1.5 bg-green-100 text-green-700 rounded-lg hover:bg-green-200 transition-colors duration-200" title="Record Payment">
                                            <i class="bi bi-credit-card"></i>
                                        </a>
                                    <?php else: ?>
                                        <span class="inline-flex items-center px-3 py-1.5 bg-gray-100 text-gray-500 rounded-lg cursor-not-allowed" title="Payment Recorded">
                                            <i class="bi bi-check-circle"></i>
                                        </span>
                                    <?php endif; ?>
                                    <form action="<?php echo e(route('orders.destroy', $order)); ?>" method="POST" class="inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" onclick="return confirm('Are you sure you want to delete this order?')" class="inline-flex items-center px-3 py-1.5 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors duration-200" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="mt-6 flex justify-center">
            <?php echo e($orders->links()); ?>

        </div>
    <?php else: ?>
        <!-- Empty State -->
        <div class="text-center py-16">
            <div class="w-24 h-24 bg-gradient-to-br from-indigo-100 to-purple-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="bi bi-inbox text-5xl text-indigo-500"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">No orders yet</h3>
            <p class="text-gray-600 mb-8 max-w-md mx-auto">Get started by creating your first laundry order. It only takes a few clicks!</p>
            <a href="<?php echo e(route('orders.create')); ?>" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                <i class="bi bi-plus-circle mr-2 text-xl"></i>
                Create First Order
            </a>
        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/gavinadlan/Documents/code/laundry_app/resources/views/orders/index.blade.php ENDPATH**/ ?>