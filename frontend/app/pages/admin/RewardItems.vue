<template>
    <div class="list">
        <div class="list-content">
            <h2 class="title">商品別の交換数</h2>
            <div class="list-card">
                <p class="section-title">【交換実績の概要】</p>
                <div class="group">
                    <div class="item-group">
                        <p class="label">登録商品数</p>
                        <p class="item">5つ</p>
                    </div>
                    <div class="item-group">
                        <p class="label">累計交換数</p>
                        <p class="item">15回</p>
                    </div>
                </div>
                <p class="section-title">【商品別の交換実績】</p>
                <div class="group">
                    <div class="item-group">
                        <table class="item-list">
                            <tbody>
                                <tr>
                                    <th>商品名</th>
                                    <th>交換回数</th>
                                </tr>
                                <template v-for="i in 5" :key="i">
                                    <tr>
                                        <td>テスト商品</td>
                                        <td>{{ i }}</td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>
                <button class="return-btn" type="button">
                    予約管理画面へ戻る
                </button>
            </div>
        </div>
    </div>
</template>

<style scoped>
p {
    margin: 0;
}

.list {
    background-color: #cce9fa;
    width: 100%;
    text-align: center;
    position: relative;
}

.list-content {
    padding: 80px 0 1px;
}

.title {
    margin: 0;
    font-size: 40px;
    color: #304654;
}

.list-card {
    width: 50%;
    max-width: 600px;
    margin: 80px auto;
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

.item-list {
    width: 100%;
    margin: 0 auto;
    text-align: center;
    border-collapse: collapse;
    border: 1px solid #304654;
    color: #304654;
    font-size: 20px;
}

tr,
th,
td {
    border-bottom: 1px solid #304654;
    text-align: left;
    padding: 5px;
}

.return-btn {
    border: none;
    background-color: #666666;
    opacity: 0.5;
    color: #eef9ff;
    padding: 10px 20px;
    margin: 30px 20px 0;
    font-size: 20px;
    cursor: pointer;
    width: 40%;
}
</style>
