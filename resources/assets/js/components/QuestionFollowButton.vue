<template>
    <button
        class="btn btn-default"
        v-bind:class="{'btn-success': followed}"
        v-text="text"
        v-on:click="follow"
    ></button>
</template>

<script>
export default {
    // 为父组件传递到子组件的属性值，子组件使用props方法接收
    // 通过props将数据传到里面
    props:['question'],
    mounted() {
        /**  这种旧的写法会在Laravel5.4中报错
         this.$http.post('/api/question/follower', {'question':this.question, 'user':this.user}).then(response => {
            console.log(response.data);
        })
         */
        // api 里面的$request->get('user')的数据是这边传递过去的 你在api里面使用Auth::id()好像不能获取到user_id
        axios.post('/api/question/follower', {'question':this.question}).then((response)=>{
            // console.log(response.data);
            this.followed = response.data.followed;
        })
    },
    data() {
        return {
            followed : false,
        }
    },
    computed: {
        text(){
            return this.followed ? '已关注' : '关注该问题';
        }
    },
    methods:{
        follow(){
            axios.post('/api/question/follow', {'question':this.question}).then((response)=>{
                // console.log(response.data);
                this.followed = response.data.followed;
            })
        }
    }
}
</script>