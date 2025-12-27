<?php $__env->startSection('content'); ?>
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-3xl font-bold text-gray-900 mb-2 flex items-center">
                <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center mr-3 shadow-lg">
                    <i class="bi bi-credit-card text-white text-lg"></i>
                </div>
                Payments
            </h1>
            <p class="text-gray-600 mt-1">Track and manage all payment records</p>
        </div>
        <a href="<?php echo e(route('payments.create')); ?>" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
            <i class="bi bi-plus-circle mr-2 text-lg"></i>
            Record Payment
        </a>
    </div>
    
    <?php if($payments->count() > 0): ?>
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-4 border border-green-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-green-600">Total Payments</p>
                        <p class="text-2xl font-bold text-green-900"><?php echo e($payments->total()); ?></p>
                    </div>
                    <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center">
                        <i class="bi bi-credit-card text-white text-xl"></i>
                    </div>
                </div>
            </div>
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-4 border border-blue-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-blue-600">Total Revenue</p>
                        <p class="text-2xl font-bold text-blue-900">
                            Rp <?php echo e(number_format($payments->sum('amount'), 0, ',', '.')); ?>

                        </p>
                    </div>
                    <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center">
                        <i class="bi bi-cash-stack text-white text-xl"></i>
                    </div>
                </div>
            </div>
            <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-4 border border-purple-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-purple-600">Average Payment</p>
                        <p class="text-2xl font-bold text-purple-900">
                            Rp <?php echo e(number_format($payments->avg('amount'), 0, ',', '.')); ?>

                        </p>
                    </div>
                    <div class="w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center">
                        <i class="bi bi-graph-up text-white text-xl"></i>
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
                            <i class="bi bi-hash mr-2"></i>Payment ID
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                            <i class="bi bi-cart mr-2"></i>Order
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                            <i class="bi bi-person mr-2"></i>Customer
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                            <i class="bi bi-currency-dollar mr-2"></i>Amount
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                            <i class="bi bi-calendar-event mr-2"></i>Payment Date
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                            <i class="bi bi-wallet2 mr-2"></i>Method
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                            <i class="bi bi-gear mr-2"></i>Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-bold text-indigo-600">#<?php echo e($payment->id); ?></span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="<?php echo e(route('orders.show', $payment->order)); ?>" class="inline-flex items-center px-3 py-1 bg-indigo-100 text-indigo-700 rounded-lg hover:bg-indigo-200 transition-colors text-sm font-semibold">
                                    <i class="bi bi-cart mr-1"></i>
                                    Order #<?php echo e($payment->order->id); ?>

                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center mr-2">
                                        <i class="bi bi-person text-indigo-600 text-xs"></i>
                                    </div>
                                    <span class="text-sm font-semibold text-gray-900"><?php echo e($payment->order->customer->name); ?></span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-green-600">
                                    Rp <?php echo e(number_format($payment->amount, 0, ',', '.')); ?>

                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    <i class="bi bi-calendar3 text-gray-400 mr-1"></i>
                                    <?php echo e(date('M d, Y', strtotime($payment->payment_date))); ?>

                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php
                                    $methodColors = [
                                        'Cash' => 'bg-green-100 text-green-800',
                                        'Bank Transfer' => 'bg-blue-100 text-blue-800',
                                        'Credit Card' => 'bg-purple-100 text-purple-800',
                                        'Debit Card' => 'bg-indigo-100 text-indigo-800',
                                        'E-Wallet' => 'bg-yellow-100 text-yellow-800',
                                    ];
                                    $color = $methodColors[$payment->method] ?? 'bg-gray-100 text-gray-800';
                                ?>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold <?php echo e($color); ?>">
                                    <i class="bi bi-wallet2 mr-1.5"></i>
                                    <?php echo e($payment->method); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <a href="<?php echo e(route('payments.show', $payment)); ?>" class="inline-flex items-center px-3 py-1.5 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors duration-200" title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <form action="<?php echo e(route('payments.destroy', $payment)); ?>" method="POST" class="inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" onclick="return confirm('Are you sure you want to delete this payment?')" class="inline-flex items-center px-3 py-1.5 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors duration-200" title="Delete">
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
            <?php echo e($payments->links()); ?>

        </div>
    <?php else: ?>
        <!-- Empty State -->
        <div class="text-center py-16">
            <div class="w-24 h-24 bg-gradient-to-br from-indigo-100 to-purple-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="bi bi-credit-card text-5xl text-indigo-500"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">No payments recorded yet</h3>
            <p class="text-gray-600 mb-8 max-w-md mx-auto">Start recording payments for your orders. Track revenue and payment methods easily.</p>
            <a href="<?php echo e(route('payments.create')); ?>" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                <i class="bi bi-plus-circle mr-2 text-xl"></i>
                Record First Payment
            </a>
        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/gavinadlan/Documents/code/laundry_app/resources/views/payments/index.blade.php ENDPATH**/ ?>