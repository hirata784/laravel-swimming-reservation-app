<template>
    <div class="reservation">
        <div class="reservation-content">
            <h2 class="title">予約管理</h2>
            <div class="reservation-form">
                <div class="week-pagination">
                    <button class="week-btn">← 前の週</button>
                    <p>9/21~9/27</p>
                    <button class="week-btn">次の週 →</button>
                </div>
                <div v-for="j in 7">
                    <p class="date">9/21(月)</p>
                    <div v-for="i in 10" class="group">
                        <div class="item-group">
                            <p class="time">
                                {{ (i + 8).toString().padStart(2, "0") }}:00
                            </p>
                            <p class="reservation-people">3/7人</p>
                            <button class="detail-btn" type="button">
                                詳細
                            </button>
                        </div>
                        <div class="item-group">
                            <p class="time">
                                {{ (i + 8).toString().padStart(2, "0") }}:30
                            </p>
                            <p class="reservation-people">5/7人</p>
                            <button class="detail-btn" type="button">
                                詳細
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
definePageMeta({
    layout: "admin", // 管理者用のヘッダーを表示
    middleware: "admin-auth", // 認証中のみアクセス可能にする
});
</script>

<style scoped>
p {
    margin: 0;
}

.reservation {
    background-color: #cce9fa;
    width: 100%;
    text-align: center;
    position: relative;
}

.reservation-content {
    padding: 80px 0 1px;
}

.title {
    margin: 0;
    font-size: 40px;
    color: #304654;
}

.reservation-form {
    width: 50%;
    max-width: 600px;
    margin: 80px auto;
    padding: 30px 50px;
    border: 1px solid #304654;
    border-radius: 20px;
    background-color: #eef9ff;
}

.week-pagination {
    display: flex;
    justify-content: space-between;
    font-size: 20px;
}

.week-btn {
    border: none;
    background-color: #eef9ff;
    cursor: pointer;
    font-size: 20px;
}

.date {
    font-size: 20px;
    font-weight: bold;
    color: #304654;
    text-align: left;
    margin-top: 20px;
}

.group {
    background-color: #ffffff;
    padding: 0 15px;
}

.item-group {
    width: 100%;
    display: flex;
    flex-direction: row;
    align-items: center;
}

.time {
    font-size: 20px;
    color: #304654;
    text-align: left;
    width: 30%;
}

.reservation-people {
    font-size: 18px;
    color: #304654;
    text-align: left;
    width: 30%;
}

.detail-btn {
    border: none;
    background-color: #99b1ea;
    color: #eef9ff;
    cursor: pointer;
    padding: 10px 0;
    width: 25%;
    margin: 5px 0;
    font-size: 20px;
}
</style>
