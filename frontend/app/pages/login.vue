<template>
    <div class="login">
        <div class="login-content">
            <h2 class="title">ログイン</h2>
            <form class="login-form">
                <div class="group">
                    <p class="item">メールアドレス</p>
                    <input
                        class="txt"
                        type="text"
                        placeholder="例：test@example.com"
                    />
                </div>
                <div class="group">
                    <p class="item">パスワード</p>
                    <input class="txt" type="text" placeholder="例：test1234" />
                </div>
                <button class="login-btn">ログインする</button>
            </form>
        </div>
    </div>
</template>

<style scoped>
p {
    margin: 0;
}

.login {
    background-color: #cce9fa;
    width: 100%;
    height: 90vh;
    text-align: center;
}

.login-content {
    padding-top: 80px;
}

.title {
    margin: 0;
    font-size: 40px;
    color: #304654;
}

.login-form {
    width: 60%;
    margin: 80px auto;
    padding: 30px 60px;
    border: 1px solid #304654;
    border-radius: 20px;
    background-color: #eef9ff;
}

.group {
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

.login-btn {
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
