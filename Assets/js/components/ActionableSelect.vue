<template>
    <div>
        This is component body.
        <select v-model="input" @change="valueChanged">
            <slot></slot>
        </select>
    </div>
</template>

<script>
export default {
    props: {
        url: {
            type: String,
            required: true,
        },
        method: {
            type: String,
            default: 'PUT',
        },
        value: {
            type: [String, Number],
            default: '',
        }
    },
    data(){
        return {
            input: ''
        }
    },
    mounted(){
        alert('Hello 2');
        this.input = this.value;
    },
    methods: {
        valueChanged(){
            console.log(this.input);
        }
    }
}
</script>