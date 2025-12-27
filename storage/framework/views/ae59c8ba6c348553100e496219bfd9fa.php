<?php $__env->startSection('content'); ?>
    <div class="mb-6">
        <div class="flex items-center mb-2">
            <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center mr-3 shadow-lg">
                <i class="bi bi-cart-plus text-white text-lg"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-900">Create New Order</h1>
        </div>
        <p class="text-gray-600">Create a new laundry order for a customer</p>
    </div>

    <form action="<?php echo e(route('orders.store')); ?>" method="POST" class="space-y-6" id="orderForm">
        <?php echo csrf_field(); ?>
        
        <!-- Customer & Dates Section -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Customer -->
            <div>
                <label for="customer_id" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="bi bi-person mr-2 text-indigo-600"></i>Customer <span class="text-red-500">*</span>
                </label>
                <select name="customer_id" 
                        id="customer_id" 
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 outline-none bg-white <?php $__errorArgs = ['customer_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <option value="">Select a customer</option>
                    <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($customer->id); ?>" <?php echo e(old('customer_id') == $customer->id ? 'selected' : ''); ?>>
                            <?php echo e($customer->name); ?> <?php if($customer->phone): ?> - <?php echo e($customer->phone); ?> <?php endif; ?>
                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['customer_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-sm text-red-600 flex items-center">
                        <i class="bi bi-exclamation-circle mr-1"></i><?php echo e($message); ?>

                    </p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Order Date -->
            <div>
                <label for="order_date" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="bi bi-calendar-event mr-2 text-indigo-600"></i>Order Date <span class="text-red-500">*</span>
                </label>
                <input type="date" 
                       name="order_date" 
                       id="order_date" 
                       value="<?php echo e(old('order_date', date('Y-m-d'))); ?>" 
                       required
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 outline-none <?php $__errorArgs = ['order_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                <?php $__errorArgs = ['order_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-sm text-red-600 flex items-center">
                        <i class="bi bi-exclamation-circle mr-1"></i><?php echo e($message); ?>

                    </p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Delivery Date -->
            <div>
                <label for="delivery_date" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="bi bi-calendar-check mr-2 text-indigo-600"></i>Delivery Date
                </label>
                <input type="date" 
                       name="delivery_date" 
                       id="delivery_date" 
                       value="<?php echo e(old('delivery_date')); ?>"
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 outline-none <?php $__errorArgs = ['delivery_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                <?php $__errorArgs = ['delivery_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-sm text-red-600 flex items-center">
                        <i class="bi bi-exclamation-circle mr-1"></i><?php echo e($message); ?>

                    </p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </div>

        <!-- Status -->
        <div>
            <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">
                <i class="bi bi-info-circle mr-2 text-indigo-600"></i>Status <span class="text-red-500">*</span>
            </label>
            <select name="status" 
                    id="status" 
                    required
                    class="w-full md:w-1/3 px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 outline-none bg-white <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                <?php $__currentLoopData = [\App\Models\Order::STATUS_PENDING, \App\Models\Order::STATUS_IN_PROGRESS, \App\Models\Order::STATUS_COMPLETED, \App\Models\Order::STATUS_DELIVERED]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($status); ?>" <?php echo e(old('status', \App\Models\Order::STATUS_PENDING) == $status ? 'selected' : ''); ?>>
                        <?php echo e(ucfirst(str_replace('_', ' ', $status))); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="mt-1 text-sm text-red-600 flex items-center">
                    <i class="bi bi-exclamation-circle mr-1"></i><?php echo e($message); ?>

                </p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <!-- Services Section -->
        <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
            <div class="flex items-center justify-between mb-4">
                <label class="block text-sm font-semibold text-gray-700">
                    <i class="bi bi-list-check mr-2 text-indigo-600"></i>Services <span class="text-red-500">*</span>
                </label>
                <span class="text-xs text-gray-500">Enter quantity for each service (0 to exclude)</span>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 bg-white rounded-lg overflow-hidden">
                    <thead class="bg-gradient-to-r from-indigo-600 to-purple-600">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Service</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Price</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Quantity</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="service-row hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <input type="hidden" name="services[<?php echo e($index); ?>][service_id]" value="<?php echo e($service->id); ?>">
                                        <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center mr-3">
                                            <i class="bi bi-check-circle text-indigo-600"></i>
                                        </div>
                                        <div>
                                            <div class="text-sm font-semibold text-gray-900"><?php echo e($service->name); ?></div>
                                            <?php if($service->description): ?>
                                                <div class="text-xs text-gray-500"><?php echo e(Str::limit($service->description, 40)); ?></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-semibold text-gray-900">Rp <?php echo e(number_format($service->price, 0, ',', '.')); ?></span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="number" 
                                           name="services[<?php echo e($index); ?>][quantity]" 
                                           value="<?php echo e(old('services.' . $index . '.quantity', 0)); ?>" 
                                           min="0"
                                           data-price="<?php echo e($service->price); ?>"
                                           class="quantity-input w-24 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 outline-none text-center"
                                           onchange="calculateTotal()">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="subtotal text-sm font-semibold text-green-600">Rp 0</span>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                    <tfoot class="bg-gray-50">
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-right text-sm font-bold text-gray-700">Total:</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span id="totalAmount" class="text-lg font-bold text-indigo-600">Rp 0</span>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Notes -->
        <div>
            <label for="notes" class="block text-sm font-semibold text-gray-700 mb-2">
                <i class="bi bi-sticky mr-2 text-indigo-600"></i>Notes
            </label>
            <textarea name="notes" 
                      id="notes" 
                      rows="3"
                      class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 outline-none resize-none <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                      placeholder="Add any special instructions or notes for this order..."><?php echo e(old('notes')); ?></textarea>
            <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="mt-1 text-sm text-red-600 flex items-center">
                    <i class="bi bi-exclamation-circle mr-1"></i><?php echo e($message); ?>

                </p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <!-- Form Actions -->
        <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
            <a href="<?php echo e(route('orders.index')); ?>" class="px-6 py-3 border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition duration-200">
                <i class="bi bi-x-circle mr-2"></i>Cancel
            </a>
            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                <i class="bi bi-check-circle mr-2"></i>Create Order
            </button>
        </div>
    </form>

    <script>
        function calculateTotal() {
            let total = 0;
            document.querySelectorAll('.quantity-input').forEach(input => {
                const quantity = parseInt(input.value) || 0;
                const price = parseFloat(input.dataset.price) || 0;
                const subtotal = quantity * price;
                
                const row = input.closest('tr');
                const subtotalElement = row.querySelector('.subtotal');
                subtotalElement.textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
                
                total += subtotal;
            });
            
            document.getElementById('totalAmount').textContent = 'Rp ' + total.toLocaleString('id-ID');
        }
        
        // Calculate on page load
        document.addEventListener('DOMContentLoaded', calculateTotal);
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/gavinadlan/Documents/code/laundry_app/resources/views/orders/create.blade.php ENDPATH**/ ?>