<template>
    <div class="header">
        <h1 class="header-str">▼●▲水泳クラブ</h1>
        <nav class="header-nav">
            <button class="btn">マイページ</button>
            <button class="btn">ログイン</button>
        </nav>
    </div>
</template>

<style scoped>
p {
    margin: 0;
}

body {
    margin: 0;
}

.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #3cabe3;
    height: 9dvh;
}

.header-str {
    color: #eef9ff;
    padding-left: 20px;
    margin: 0;
}

.header-nav {
    width: 20%;
    padding-right: 20px;
    display: flex;
    justify-content: space-between;
}

.btn {
    border: none;
    background-color: #3cabe3;
    color: #eef9ff;
    padding: 8px 16px;
    font-size: 20px;
    cursor: pointer;
}
</style>
