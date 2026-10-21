<template>
    <div class="rewards">
        <div class="rewards-content">
            <h2 class="title">特典利用</h2>
            <div class="rewards-form">
                <p class="section-title">【使用者情報】</p>
                <div class="group">
                    <div class="item-group">
                        <p class="label">名前</p>
                        <p class="item">テスト</p>
                    </div>
                    <div class="item-group">
                        <p class="label">未使用特典</p>
                        <p class="item">1枚</p>
                    </div>
                </div>
                <p class="section-title">【交換する商品を選択してください】</p>
                <div class="group">
                    <div class="radio-group">
                        <input
                            type="radio"
                            id="sports-drink"
                            name="rewards"
                            value="スポーツドリンク"
                        />
                        <label class="item" for="sports-drink"
                            >スポーツドリンク</label
                        >
                    </div>
                    <div class="radio-group">
                        <input
                            type="radio"
                            id="bath-additive"
                            name="rewards"
                            value="入浴剤"
                        />
                        <label class="item" for="bath-additive">入浴剤</label>
                    </div>
                    <div class="radio-group">
                        <input
                            type="radio"
                            id="skincare-set"
                            name="rewards"
                            value="スキンケアセット"
                        />
                        <label class="item" for="skincare-set"
                            >スキンケアセット</label
                        >
                    </div>
                    <div class="radio-group">
                        <input
                            type="radio"
                            id="amino-acid-jelly"
                            name="rewards"
                            value="アミノ酸ゼリー"
                        />
                        <label class="item" for="amino-acid-jelly"
                            >アミノ酸ゼリー</label
                        >
                    </div>
                    <div class="radio-group">
                        <input
                            type="radio"
                            id="protein-bar"
                            name="rewards"
                            value="プロテインバー"
                        />
                        <label class="item" for="protein-bar"
                            >プロテインバー</label
                        >
                    </div>
                </div>
                <div class="btn-area">
                    <button class="exchange-btn">交換を確定する</button>
                    <button class="return-btn">キャンセル</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
// useRoute呼び出し
const route = useRoute();
// ユーザーid取得
const userId = route.params.userId;

definePageMeta({
    layout: "admin", // 管理者用のヘッダーを表示
    middleware: "admin-auth", // 認証中のみアクセス可能にする
});
</script>

<style scoped>
p {
    margin: 0;
}

.rewards {
    background-color: #cce9fa;
    width: 100%;
    text-align: center;
    position: relative;
}

.rewards-content {
    padding: 80px 0 1px;
}

.title {
    margin: 0;
    font-size: 40px;
    color: #304654;
}

.rewards-form {
    width: 50%;
    margin: 80px auto;
    max-width: 600px;
    padding: 30px 50px;
    border: 1px solid #304654;
    border-radius: 20px;
    background-color: #eef9ff;
}

.section-title {
    font-size: 20px;
    font-weight: bold;
    color: #304654;
    text-align: left;
    margin-top: 20px;
}

.group {
    background-color: #ffffff;
    padding: 15px;
    border-radius: 10px;
}

.item-group {
    margin-bottom: 30px;
    width: 100%;
    display: flex;
    flex-direction: column;
}

.item-group:last-child {
    margin-bottom: 0;
}

.label {
    font-size: 20px;
    font-weight: bold;
    color: #304654;
    text-align: left;
}

.item {
    font-size: 18px;
    color: #304654;
    text-align: left;
}

.radio-group {
    margin-bottom: 30px;
    width: 100%;
    display: flex;
    flex-direction: row;
}

.radio-group:last-child {
    margin-bottom: 0;
}

.btn-area {
    display: flex;
    justify-content: center;
    margin-top: 30px;
    margin-bottom: 20px;
    height: 50px;
}

.exchange-btn {
    border: none;
    background-color: #da251d;
    color: #eef9ff;
    padding: 10px 20px;
    margin: 0 20px 0;
    font-size: 20px;
    cursor: pointer;
    width: 35%;
}

.return-btn {
    border: none;
    background-color: #666666;
    opacity: 0.5;
    color: #eef9ff;
    padding: 10px 20px;
    margin: 0 20px 0;
    font-size: 20px;
    cursor: pointer;
    width: 35%;
}
</style>
