<x-app>

    <div class="grid place-items-center p-10 space-y-4">
        <h2 class="text-3xl">Create New User Account</h2>
        <form action="{{route('login')}}" method="post" class="w-96 space-y-3 p-4 rounded-lg border">
        @csrf
            
            <div class="grid space-y-2">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Enter email" class="px-4 rounded-lg">
                @error('email')
                    {{$message}}
                @enderror
            </div>
            <div class="grid space-y-2">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Enter password" class="px-4 rounded-lg">
                @error('password')
                    {{$message}}
                @enderror
            </div>
            
            <input type="submit" name="login" id="login" class="border rounded-lg p-2 bg-blue-600 text-white">
        </form>
    </div>
</x-app>