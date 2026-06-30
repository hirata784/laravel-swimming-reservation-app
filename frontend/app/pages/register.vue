<template>
    <div class="register">
        <div class="register-content">
            <h2 class="title">会員登録</h2>
            <form class="register-form" @submit.prevent="addRegister">
                <div class="group">
                    <p class="item">名前</p>
                    <input
                        v-model="name"
                        class="txt"
                        type="text"
                        placeholder="例：テスト太郎"
                    />
                </div>
                <div class="group">
                    <p class="item">メールアドレス</p>
                    <input
                        v-model="email"
                        class="txt"
                        type="text"
                        placeholder="例：test@example.com"
                    />
                </div>
                <div class="group">
                    <p class="item">パスワード</p>
                    <input
                        v-model="password"
                        class="txt"
                        type="text"
                        placeholder="例：test1234"
                    />
                </div>
                <button class="register-btn">登録する</button>
            </form>
        </div>
    </div>
</template>

<script setup>
// 入力値を定義
import { ref } from "vue";
const name = ref("");
const email = ref("");
const password = ref("");

// 登録
const addRegister = async () => {
    await $fetch("http://localhost/api/auth/register", {
        method: "POST",
        body: {
            name: name.value,
            email: email.value,
            password: password.value,
        },
    });

    // 入力値を空白にする
    name.value = "";
    email.value = "";
    password.value = "";
};
</script>

<style scoped>
p {
    margin: 0;
}

.register {
    background-color: #cce9fa;
    width: 100%;
    height: 90vh;
    text-align: center;
}

.register-content {
    padding-top: 80px;
}

.title {
    margin: 0;
    font-size: 40px;
    color: #304654;
}

.register-form {
    width: 60%;
    margin: 80px auto;
    padding: 30px 60px;
    border: 1px solid #304654;
    border-radius: 20px;
    background-color: #eef9ff;
}

.group {
    /* padding: 10px; */
    margin: 60px 0;
    width: 100%;
    display: flex;
    flex-direction: column;
}

.item {
    font-size: 18px;
    color: #304654;
    text-align: left;
}

.txt {
    font-size: 18px;
    padding: 10px;
}

.register-btn {
    border: none;
    background-color: #da251d;
    color: #eef9ff;
    padding: 10px 20px;
    font-size: 20px;
    cursor: pointer;
    width: 70%;
    margin-bottom: 60px;
}
</style>
