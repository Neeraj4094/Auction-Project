<x-app>

    <div class="grid place-items-center p-10 space-y-4">
        <h2 class="text-3xl">Create New User Account</h2>
        <form action="{{url($url)}}" method="post" class="w-96 space-y-3 p-4 rounded-lg border">
        @csrf
            <div class="grid space-y-2">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" placeholder="Enter name" class="px-4 rounded-lg" value="{{old('name')}}">
                @error('name')
                    {{$message}}
                @enderror
            </div>
            <div class="grid space-y-2">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Enter email" class="px-4 rounded-lg" value="{{old('email')}}">
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
            <div class="grid space-y-2">
                <label for="address">Address</label>
                <textarea name="address" id="address" cols="30" rows="4" class="px-4 rounded-lg" placeholder="Enter address">{{old('address')}}</textarea>
                @error('address')
                    {{$message}}
                @enderror
            </div>
            <div class="grid space-y-2">
                <fieldset>
                    <legend>Your Role</legend>
                    <div class="flex items-center justify-between">
                    @auth
                    @if(auth()->user()->role === "admin")
                    <div class="flex gap-2 items-center">
                        <input type="radio" name="role" id="admin" value="admin" {{(old('role') === "admin") ? "checked" : "" }} >
                        <label for="admin">Admin</label>
                    </div>
                    @endif
                    @if(auth()->user()->role === "admin" || auth()->user()->role === "manager")
                    <div class="flex gap-2 items-center">
                        <input type="radio" name="role" id="manager" value="manager" {{(old('role') === "manager") ? "checked" : "" }} >
                        <label for="manager">Manager</label>
                    </div>
                    @endif
                    @endauth
                    <div class="flex gap-2 items-center">
                        <input type="radio" name="role" id="employee" value="employee" {{auth()->user()->role === "employee" ? "checked" : ""}} {{(old('role') === "employee") ? "checked" : "" }} >
                        <label for="employee">Employee</label>
                    </div>
                    </div>
                </fieldset>
                @error('role')
                    {{$message}}
                @enderror
            </div>
            <input type="submit" name="register" id="register" class="border rounded-lg p-2 bg-blue-600 text-white">
        </form>
    </div>
</x-app>