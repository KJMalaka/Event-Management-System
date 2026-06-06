<x-app-layout>
    @section('title', 'Manage Users - Admin')

    <x-slot name="header">User Management</x-slot>

    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-4 py-3 text-left font-medium text-gray-500 dark:text-gray-400">User</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-500 dark:text-gray-400">Joined</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-500 dark:text-gray-400">Role</th>
                    <th class="px-4 py-3 text-right font-medium text-gray-500 dark:text-gray-400">Change Role</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                @foreach($users as $user)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-750">
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <img src="{{ $user->avatar_url }}" class="w-8 h-8 rounded-full" alt="">
                                <div>
                                    <div class="font-medium text-gray-800 dark:text-gray-200">{{ $user->name }}</div>
                                    <div class="text-xs text-gray-400">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-gray-500 dark:text-gray-400">
                            {{ $user->created_at->format('d M Y') }}
                        </td>
                        <td class="px-4 py-3">
                            <x-status-badge :status="$user->role_label"
                                :color="$user->isAdmin() ? 'red' : ($user->isOrganizer() ? 'purple' : 'blue')" />
                        </td>
                        <td class="px-4 py-3 text-right">
                            @if($user->id !== auth()->id())
                                <form method="POST" action="{{ route('admin.users.role', $user) }}" class="inline-flex items-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <select name="role"
                                            class="text-xs rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500">
                                        <option value="admin" @selected($user->role === 'admin')>Admin</option>
                                        <option value="organizer" @selected($user->role === 'organizer')>Organizer</option>
                                        <option value="attendee" @selected($user->role === 'attendee')>Attendee</option>
                                    </select>
                                    <button type="submit" class="text-xs text-blue-600 hover:underline font-medium">Save</button>
                                </form>
                            @else
                                <span class="text-xs text-gray-400">Current user</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if($users->hasPages())
            <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-700">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
