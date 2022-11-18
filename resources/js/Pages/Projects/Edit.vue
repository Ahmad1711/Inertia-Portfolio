<template>
    <Head title="Edit Project" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Project
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-md mx-auto sm:px-6 lg:px-8 bg-white">
                 <form class="p-4" @submit.prevent="submit">
                    <div>
                        <BreezeLabel for="name" value="Name" />
                        <BreezeInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" />
                        <BreezeInputError class="mt-2" :message="errors.name"/>
                    </div>

                    <div class="mt-4">
                        <BreezeLabel for="skill" value="Skill" />
                        <select name="skill_id" id="skill" v-model="form.skill_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option v-for="skill in skills" :key="skill.id" :value="skill.id"  :selected= "skill.id == project.skill_id">{{skill.name}}</option>
                        </select>
                        <BreezeInputError class="mt-2" :message="errors.skill_id"/>
                    </div>

                     <div class="mt-4">
                        <BreezeLabel for="url" value="URL" />
                        <BreezeInput id="url" type="text" class="mt-1 block w-full" v-model="form.url" />
                        <BreezeInputError class="mt-2" :message="errors.url"/>
                    </div>

                    <div class="mt-4">
                        <BreezeLabel for="image" value="Image" />
                        <BreezeInput id="image" type="file" class="mt-1 block w-full" @input="form.image = $event.target.files[0]" />
                        <BreezeInputError class="mt-2" :message="errors.image"/>
                    </div>
                    <div class="mt-4"><img :src="'/storage/'+project.image" class="w-12 h-12 rounded"></div>


                    <div class="flex items-center justify-end mt-4">
                        <BreezeButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Submit
                        </BreezeButton>
                    </div>
                </form>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import {Inertia} from '@inertiajs/inertia';
import { Head,useForm } from '@inertiajs/inertia-vue3';
import BreezeInput from '@/Components/Input.vue';
import BreezeLabel from '@/Components/Label.vue';
import BreezeInputError from '@/Components/InputError.vue';
import BreezeButton from '@/Components/Button.vue';
const props=defineProps({
    project:Object,
    skills:Array,
    errors:Object,
})
const form=useForm(props.project);
function submit() {
    // form.put(route('skills.update',form.id));
    Inertia.post(`/projects/${props.project.id}`, {
    _method: 'put',
    name:form.name,
    skill_id:form.skill_id,
    url:form.url,
    image: form.image,
    });
};
</script>
