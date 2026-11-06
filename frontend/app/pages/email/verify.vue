<template>
    <div class="verify">
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

// 認証メール再送
const isResending = async () => {
    await resending();
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
    font-size: 40px;
}

.verify-content {
    width: 90%;
    max-width: 900px;
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
