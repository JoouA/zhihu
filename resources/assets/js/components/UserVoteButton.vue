<template>
    <button
        class="btn btn-default"
        v-bind:class="{'btn-primary': voted}"
        v-text="text"
        v-on:click="vote"
    ></button>
</template>

    <script>
export default {
    // 为父组件传递到子组件的属性值，子组件使用props方法接收
    // 通过props将数据传到里面
    props:['answer','count'],
    mounted() {
        axios.post('/api/answer/'+ this.answer + '/votes/users').then((response)=>{
            // console.log(response.data);
            this.voted = response.data.voted;
        })
    },
    data() {
        return {
            voted :false,
        }
    },
    computed: {
        text(){
            return this.count;
        }
    },
    methods:{
        vote(){
            axios.post('/api/answer/vote', {'answer':this.answer}).then((response)=>{
                // console.log(response.data);
                this.voted = response.data.voted;
                response.data.voted ? this.count++ : this.count--;
            })
        }
    }
}
</script>