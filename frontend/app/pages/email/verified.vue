<template>
    <div class="verified">
        <div class="verified-content">
            <p>メール認証完了しました</p>
            <button class="profile-btn" type="button" @click="profile">
                プロフィール画面へ
            </button>
        </div>
    </div>
</template>

<script setup>
// 認証中のみアクセス可能にする
definePageMeta({
    middleware: "auth",
});

const profile = () => {
    // プロフィール設定画面へ遷移する
    return navigateTo("/profile");
};
</script>

<style scoped>
p {
    margin: 0;
}

.verified {
    background-color: #cce9fa;
    width: 100%;
    height: 90vh;
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    color: #304654;
}

.verified-content {
    width: 90%;
    max-width: 900px;
    font-size: 40px;
}

.profile-btn {
    border: none;
    background-color: #99b1ea;
    color: #eef9ff;
    padding: 10px 20px;
    margin: 0 20px 0;
    font-size: 20px;
    cursor: pointer;
    width: 60%;
}
</style>
