<script setup>
import { useForm } from "@inertiajs/vue3";

const form = useForm({
    username: "",
    password: "",
    remember: false,
});

const submit = () => {
    form.post(route("login"), {
        onFinish: () => form.reset("password"),
    });
};

</script>

<template>
    <div
        class="bg-surface-50 dark:bg-surface-950 flex items-center justify-center min-h-screen min-w-[100vw] overflow-hidden">
        <div class="flex flex-col items-center justify-center">
            <div
                style="border-radius: 56px; padding: 0.3rem; background: linear-gradient(180deg, var(--primary-color) 10%, rgba(33, 150, 243, 0) 30%)">
                <div class="w-full bg-surface-0 dark:bg-surface-900 py-20 px-8 sm:px-20" style="border-radius: 53px">
                    <div class="text-center mb-8">
                     
                        <div class="mb-8 w-16 shrink-0 mx-auto">
                            <img src="demo/images/logo_circle.png" width="150" height="150" style="max-width:120%;" alt="Logo" />
                        </div>
                        
                        <div class="text-surface-900 dark:text-surface-0 text-3xl font-medium mb-4">Welcome CSA IT DEV!
                        </div>
                        <span class="text-neutral-500 font-medium">Sign in to continue</span>
                    </div>

                    <form @submit.prevent="submit">
                        <div>
                            <label for="username" class="block text-surface-900 dark:text-surface-0 text-xl font-medium mb-2">Username</label>
                            <!-- <input
                                type="text"
                                id="username"
                                v-model="form.username"
                                required
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-500"
                            /> -->
                            <InputText id="username" type="text" placeholder="Username" class="w-full md:w-[30rem] mb-4"
                                v-model="form.username" required/>
                            <!-- <Message v-if="form.errors.email" class="mb-4" severity="error">{{ form.errors.email }}
                            </Message> -->

                            <label for="password1"
                                class="block text-surface-900 dark:text-surface-0 font-medium text-xl mb-2">Password</label>
                            <Password id="password1" v-model="form.password" placeholder="Password" :toggleMask="true"
                                class="mb-4" fluid :feedback="false"></Password>
                            <Message v-if="form.errors.password" class="mb-4" severity="error">{{ form.errors.password
                                }}</Message>

                            <div class="flex items-center justify-between mt-2 mb-8 gap-8">
                                <div class="flex items-center text-neutral-500">
                                    <Checkbox v-model="form.remember" id="rememberme1" binary class="mr-2"></Checkbox>
                                    <label for="rememberme1">Remember me</label>
                                </div>
                                <span
                                    class="font-medium no-underline ml-2 text-right cursor-pointer text-primary">Forgot
                                    password?</span>
                            </div>
                            <Button type="submit" label="Sign In" class="w-full"></Button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.pi-eye {
    transform: scale(1.6);
    margin-right: 1rem;
}

.pi-eye-slash {
    transform: scale(1.6);
    margin-right: 1rem;
}
</style>
