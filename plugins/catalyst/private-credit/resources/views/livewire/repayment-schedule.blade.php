<div>
    <div class="p-4">
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            Estimated Repayment Schedule
        </h2>

        <div class="mt-4">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-1 md:px-6 py-3">Due Date</th>
                        <th scope="col" class="px-1 md:px-6 py-3">Repayment</th>
                        <th scope="col" class="px-1 md:px-6 py-3">Principal</th>
                        <th scope="col" class="px-1 md:px-6 py-3">Interest</th>
                        <th scope="col" class="px-1 md:px-6 py-3">Balance</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($this->schedule as $item)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="px-1 md:px-6 py-4">{{ $item['due_date'] }}</td>
                            <td class="px-1 md:px-6 py-4">${{ $item['repayment'] }}</td>
                            <td class="px-1 md:px-6 py-4">${{ $item['principal'] }}</td>
                            <td class="px-1 md:px-6 py-4">${{ $item['interest'] }}</td>
                            <td class="px-1 md:px-6 py-4">${{ $item['balance'] }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center">
                                Please fill in all the required loan details to view the schedule.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
