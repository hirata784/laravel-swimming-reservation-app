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
                            <!-- 9時は頭を0で埋める(09:00) -->
                            <th>
                                {{ (i + 8).toString().padStart(2, "0") }}:00
                            </th>
                            <template v-for="j in 7">
                                <!-- 9時は頭を0で埋める(09:00) -->
                                <td
                                    :class="
                                        getStatusInfo(
                                            `${year}-${month}-${dates[j - 1]}`,
                                            `${(i + 8).toString().padStart(2, 0)}:00`,
                                        ).class
                                    "
                                >
                                    {{
                                        getStatusInfo(
                                            `${year}-${month}-${dates[j - 1]}`,
                                            `${(i + 8).toString().padStart(2, 0)}:00`,
                                        ).text
                                    }}
                                </td>
                            </template>
                        </tr>
                        <tr>
                            <!-- 9時は頭を0で埋める(09:00) -->
                            <th>
                                {{ (i + 8).toString().padStart(2, "0") }}:30
                            </th>
                            <template v-for="j in 7">
                                <!-- 9時は頭を0で埋める(09:00) -->
                                <td
                                    :class="
                                        getStatusInfo(
                                            `${year}-${month}-${dates[j - 1]}`,
                                            `${(i + 8).toString().padStart(2, 0)}:30`,
                                        ).class
                                    "
                                >
                                    {{
                                        getStatusInfo(
                                            `${year}-${month}-${dates[j - 1]}`,
                                            `${(i + 8).toString().padStart(2, 0)}:30`,
                                        ).text
                                    }}
                                </td>
                            </template>
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
// 月(1~9月は頭を0で埋める(例：01月))
const month = (today.getMonth() + 1).toString().padStart(2, "0");
// 日にち
const dates = ref([]);
// 曜日
const days = ref([]);
// 曜日のテキスト
const weekday = ["日", "月", "火", "水", "木", "金", "土"];
// 予約データ(年月日と時間)
const reservations = ref([]);

// 7日分用意する
for (let i = 0; i < 7; i++) {
    const d = new Date(today);
    // 月末日に+1した場合、自動的に翌月の1日に進む
    d.setDate(today.getDate() + i);
    // 日にちを取得(1~9日は頭を0で埋める(例：01日))
    dates.value.push(d.getDate().toString().padStart(2, "0"));
    // 曜日を取得
    days.value.push(weekday[d.getDay()]);
}

// 予約データの作成
const makeReservations = async () => {
    const res = await $fetch("http://localhost/api/reservation", {
        method: "GET",
    });
    for (let i = 0; i < res.data.start_time.length; i++) {
        reservations.value.push({
            date: res.data.date[i],
            time: res.data.start_time[i].substring(0, 5),
        });
    }
};

// 予約のカウントと予約状況の表示
function getStatusInfo(date, time) {
    const count = reservations.value.filter(
        (r) => r.date === date && r.time === time,
    ).length;

    if (count >= 2) return { text: "×", class: "bg-gray" };
    if (count >= 1) return { text: "△", class: "bg-yellow" };
    return { text: "⚪︎", class: "bg-green" };
}

makeReservations();
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

.bg-green {
    background-color: #55c6a9;
}

.bg-yellow {
    background-color: #fce77c;
}

.bg-gray {
    background-color: #7f8c8d;
}
</style>
