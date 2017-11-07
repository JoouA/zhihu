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
    props:['user'],
    mounted() {
        axios.get('/api/user/followers/'+ this.user).then((response)=>{
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
            return this.followed ? '已关注' : '关注ta';
        }
    },
    methods:{
        follow(){
            axios.post('/api/user/follow', {'user':this.user
            }).then((response)=>{
                // console.log(response.data);
                this.followed = response.data.followed;
            })
        }
    }
}
</script>