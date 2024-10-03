<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/Auth/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import Checkbox from "@/Components/Checkbox.vue";

const form = useForm({
    name: '',
    email: '',
    phone_number: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout heading="Welcome" subheading="Create your free account" >
        <Head title="Register" />

        <form @submit.prevent="submit" id="register" v-if="!showMe">
            <div class="input-wrap" >
                <InputLabel for="name" value="Name" class="sr-only" />

                <i class="input-icon far fa-user"></i>
                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                    placeholder="Full Name"
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="input-wrap mt-8">
                <InputLabel for="email" value="Email" class="sr-only" />

                <i class="input-icon far fa-envelope"></i>
                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autocomplete="username"
                    placeholder="Email Address"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="input-wrap mt-8">
                <InputLabel for="phone_number" value="Password" class="sr-only" />

                <i class="input-icon fas fa-phone"></i>
                <TextInput
                    id="phone_number"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.phone_number"
                    required
                    autocomplete="phone_number"
                    placeholder="Phone Number"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="input-wrap mt-8">
                <InputLabel for="password" value="Password" class="sr-only" />

                <i class="input-icon fas fa-lock"></i>
                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                    placeholder="Create Password"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="input-wrap mt-8 mb-16">
                <InputLabel for="password_confirmation" value="Confirm Password" class="sr-only" />

                <i class="input-icon fas fa-key"></i>
                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                    placeholder="Confirm Password"
                />

                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>
          <div class="input-wrap mt-8 mb-16">
            <Checkbox id="terms" required></Checkbox>
            <label for="terms" class="check-label">I agree to <button class="link-item"  @click="showMe = !showMe">terms & conditions</button></label>
          </div>
            <div class="flex flex-col items-center justify-end mt-4">

                <button class="btn-primary mb-6" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Sign Up
                </button>

                <Link
                    :href="route('login')"
                    class="btn-primary"
                >
                    Return to Login
                </Link>
            </div>
        </form>
      <div class="input-wrap" v-if="showMe">
        <h3 class="terms">Terms of Service</h3>
        <p class="terms-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus et eleifend lacus. Nam vulputate ornare ante, eget tristique lorem dapibus vitae. Maecenas velit magna, lobortis vitae tincidunt sit amet, suscipit vel enim. Ut ut quam purus. Proin nisl diam, mattis sit amet commodo sed, vulputate ac purus. Donec faucibus enim ex, non commodo mauris sagittis vel. Etiam ac turpis venenatis, congue magna eget, molestie velit. Integer suscipit magna quis consectetur bibendum. Dum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Suspendisse placerat ac velit a finibus. Quisque feugiat massa in eleifend aliquam. Quisque ornare ligula ut turpis aliquam scelerisque. Aenean purus tellus, scelerisque tristique quam eget, pellentesque tincidunt lacus. Fusce vestibulum, risus sit amet varius bibendum, augue neque finibus nulla, vel accumsan urna dolor eget purus. Ut vel luctus diam. Nulla at aliquam quam.</p>

        <p class="terms-text">   Maecenas eu urna aliquet, hendrerit nibh eget, convallis sem. Praesent convallis lobortis arcu at consequat. Aenean sed interdum nibh. Quisque mauris nisl, consequat a est quis, facilisis convallis enim. Aenean ut eros pretium, rhoncus purus vitae, tincidunt felis. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus et eleifend lacus. Nam vulputate ornare ante, eget tristique lorem dapibus vitae. Maecenas velit magna, lobortis vitae tincidunt sit amet, suscipit vel enim. Ut ut quam purus. Proin nisl diam, mattis sit amet commodo sed, vulputate ac purus. Donec faucibus enim ex, non commodo mauris sagittis vel. Etiam ac turpis venenatis, congue magna eget, molestie velit. Integer suscipit magna quis consectetur bibendum. Dum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Suspendisse placerat ac velit a finibus.       </p>
        <div class="flex flex-col items-center justify-end mt-4">
          <button  @click="showMe = !showMe"
                class="btn-primary">
            I UNDERSTAND
          </button>
        </div>
      </div>
    </GuestLayout>
</template>
<script>
export default {
  name: "Register",
  data() {
    return {
      showMe: false,
    };
  },
  methods: {
    showHide() {
      this.isShow = false;
      this.isShowTerms = true;
    }
  }
}
</script>
