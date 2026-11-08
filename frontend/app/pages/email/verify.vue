<template>
    <div class="verify">
        <p v-if="message" class="message">{{ message }}</p>
        <div class="verify-content">
            <p>確認メールを送信しました。</p>
            <p>アカウント作成を完了するため、メールをご確認ください。</p>
            <div>
                <button
                    class="resending-btn"
                    type="button"
                    @click="isResending"
                >
                    確認メールを再送信する
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
// { resending: 認証メール再送関数 }
const { resending } = useAuth();
// 確認メール再送のメッセージ
const message = ref("");
// メッセージ表示用のタイマー
let messageTimerId = null;

// 認証中のみアクセス可能にする
definePageMeta({
    middleware: "auth",
});

// 認証メール再送
const isResending = async () => {
    // タイマーをリセットする
    clearTimeout(messageTimerId);
    const result = await resending();

    // 再送に失敗した場合、メッセージを表示しない
    if (!result) return;
    message.value = "確認メールを再送しました";

    // 3秒後にメッセージが非表示になる
    messageTimerId = setTimeout(() => {
        message.value = "";
    }, 3000);
};
</script>

<style scoped>
p {
    margin: 0;
}

.verify {
    background-color: #cce9fa;
    width: 100%;
    height: 90vh;
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    color: #304654;
    position: relative;
}

.message {
    background-color: #55c6a9;
    color: #304654;
    padding: 10px 20px;
    text-align: left;
    position: absolute;
    width: 100%;
    box-sizing: border-box;
    top: 0%;
}

.verify-content {
    width: 90%;
    max-width: 900px;
    font-size: 40px;
}

.resending-btn {
    border: none;
    background-color: #99b1ea;
    color: #eef9ff;
    padding: 10px 20px;
    margin: 0 20px 0;
    font-size: 20px;
    cursor: pointer;
    width: 80%;
}
</style>
