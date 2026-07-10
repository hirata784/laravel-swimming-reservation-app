<template>
    <div class="reservation">
        <div class="reservation-content">
            <h2 class="title">{{ year }}年{{ month }}月</h2>
            <table class="reservation-list">
                <tbody>
                    <tr>
                        <th>受付時刻</th>
                        <template v-for="i in 7">
                            <th>{{ dates[i - 1] }}({{ days[i - 1] }})</th>
                        </template>
                    </tr>
                    <template v-for="i in 10">
                        <tr>
                            <th>{{ i + 8 }}:00</th>
                            <td>⚪︎</td>
                            <td>⚪︎</td>
                            <td>⚪︎</td>
                            <td>⚪︎</td>
                            <td>⚪︎</td>
                            <td>⚪︎</td>
                            <td>⚪︎</td>
                        </tr>
                        <tr>
                            <th>{{ i + 8 }}:30</th>
                            <td>⚪︎</td>
                            <td>⚪︎</td>
                            <td>⚪︎</td>
                            <td>⚪︎</td>
                            <td>⚪︎</td>
                            <td>⚪︎</td>
                            <td>⚪︎</td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script setup>
// 今日の日付を取得
const today = new Date();
// 年
const year = today.getFullYear();
// 月
const month = today.getMonth() + 1;
// 日にち
const dates = ref([]);
// 曜日
const days = ref([]);
// 曜日のテキスト
const weekday = ["日", "月", "火", "水", "木", "金", "土"];

// 7日分用意する
for (let i = 0; i < 7; i++) {
    const d = new Date(today);
    // 月末日に+1した場合、自動的に翌月の1日に進む
    d.setDate(today.getDate() + i);
    // 日にちを取得
    dates.value.push(d.getDate());
    // 曜日を取得
    days.value.push(weekday[d.getDay()]);
}
</script>

<style scoped>
.reservation {
    background-color: #cce9fa;
    width: 100%;
    height: 110vh;
    text-align: center;
}

.reservation-content {
    padding-top: 80px;
}

.title {
    margin: 0;
    font-size: 40px;
    color: #304654;
}

.reservation-list {
    width: 90%;
    height: 80vh;
    margin: 80px auto 0;
    text-align: center;
    align-items: center;
    border-collapse: collapse;
    border: 1px solid #304654;
    color: #304654;
}

tr,
th,
td {
    border: 1px solid #304654;
}
</style>
