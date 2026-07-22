<template>
    <div class="reservation">
        <div class="reservation-content">
            <h2 class="title">{{ year }}年{{ month }}月</h2>
            <div class="table-scroll-wrapper">
                <table class="reservation-list">
                    <tbody>
                        <tr>
                            <th class="fix-th">受付時刻</th>
                            <template v-for="i in 7">
                                <th class="fix-th">
                                    {{ dates[i - 1] }}({{ days[i - 1] }})
                                </th>
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
                                        v-if="isLoggedIn"
                                        :class="
                                            statusMap[
                                                `${year}-${month}-${dates[j - 1]}_${(i + 8).toString().padStart(2, '0')}:00`
                                            ].class
                                        "
                                    >
                                        <!-- ログイン：ボタン表示 クリックした日時をconfirmへ渡す -->
                                        <button
                                            class="table-cell-btn"
                                            @click="
                                                confirm(
                                                    `${year}-${month}-${dates[j - 1]}`,
                                                    `${(i + 8).toString().padStart(2, '0')}:00`,
                                                )
                                            "
                                        >
                                            {{
                                                statusMap[
                                                    `${year}-${month}-${dates[j - 1]}_${(i + 8).toString().padStart(2, "0")}:00`
                                                ].text
                                            }}
                                        </button>
                                    </td>
                                    <td
                                        v-else
                                        :class="
                                            statusMap[
                                                `${year}-${month}-${dates[j - 1]}_${(i + 8).toString().padStart(2, '0')}:00`
                                            ].class
                                        "
                                    >
                                        <!-- ログアウト：テキスト表示 -->
                                        {{
                                            statusMap[
                                                `${year}-${month}-${dates[j - 1]}_${(i + 8).toString().padStart(2, "0")}:00`
                                            ].text
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
                                        v-if="isLoggedIn"
                                        :class="
                                            statusMap[
                                                `${year}-${month}-${dates[j - 1]}_${(i + 8).toString().padStart(2, '0')}:30`
                                            ].class
                                        "
                                    >
                                        <!-- ログイン：ボタン表示 クリックした日時をconfirmへ渡す -->
                                        <button
                                            class="table-cell-btn"
                                            @click="
                                                confirm(
                                                    `${year}-${month}-${dates[j - 1]}`,
                                                    `${(i + 8).toString().padStart(2, '0')}:30`,
                                                )
                                            "
                                        >
                                            {{
                                                statusMap[
                                                    `${year}-${month}-${dates[j - 1]}_${(i + 8).toString().padStart(2, "0")}:30`
                                                ].text
                                            }}
                                        </button>
                                    </td>
                                    <td
                                        v-else
                                        :class="
                                            statusMap[
                                                `${year}-${month}-${dates[j - 1]}_${(i + 8).toString().padStart(2, '0')}:30`
                                            ].class
                                        "
                                    >
                                        <!-- ログアウト：テキスト表示 -->
                                        {{
                                            statusMap[
                                                `${year}-${month}-${dates[j - 1]}_${(i + 8).toString().padStart(2, "0")}:30`
                                            ].text
                                        }}
                                    </td>
                                </template>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script setup>
// 今日の日付を取得
const today = new Date();
// 今年
const year = today.getFullYear();
// 今月(1~9月は頭を0で埋める(例：01月))
const month = (today.getMonth() + 1).toString().padStart(2, "0");
// 現在の時間
const hour = today.getHours();
// 現在の分
const minute = today.getMinutes().toString().padStart(2, "0");
// 現在の時刻
const currentTime = `${hour}:${minute}`;
// 日にち
const dates = ref([]);
// 曜日
const days = ref([]);
// 曜日のテキスト
const weekday = ["日", "月", "火", "水", "木", "金", "土"];
// 予約一覧
// 例: [{ date: "2026-07-15", time: "09:00" }]
const reservations = ref([]);
// ログイン状態
const token = useCookie("token");
const isLoggedIn = computed(() => {
    return !!token.value;
});

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
    // APIの配列を1つずつ整形
    for (let i = 0; i < res.data.start_time.length; i++) {
        reservations.value.push({
            date: res.data.date[i],
            time: res.data.start_time[i].substring(0, 5),
        });
    }
};

// 予約数を集計する
const reservationMap = computed(() => {
    const map = {};

    reservations.value.forEach((r) => {
        const key = `${r.date}_${r.time}`;
        // map[key]が存在しない場合、0に1をプラス
        map[key] = (map[key] || 0) + 1;
    });

    return map;
});

// 表示用データをすべて作成する
const statusMap = computed(() => {
    const result = {};

    // 各日付
    for (let d of dates.value) {
        // 各時間
        for (let h = 9; h <= 18; h++) {
            // 00分or30分
            for (let m of ["00", "30"]) {
                // 時間
                const time = `${h.toString().padStart(2, "0")}:${m}`;
                // 日付
                const date = `${year}-${month}-${d}`;
                // キー
                const key = `${date}_${time}`;
                // 予約取得数(reservationMap.value[key]が存在しない場合、0を取得)
                const count = reservationMap.value[key] || 0;

                // 状態決定
                // 過去の日時の場合、予約0でも予約不可能とする
                if (dates.value[0] == d && currentTime > time) {
                    result[key] = { text: "×", class: "bg-gray" };
                    // 予約人数によって、表示を変更する
                } else if (count >= 2) {
                    result[key] = { text: "×", class: "bg-gray" };
                } else if (count >= 1) {
                    result[key] = { text: "△", class: "bg-yellow" };
                } else {
                    result[key] = { text: "⚪︎", class: "bg-green" };
                }
            }
        }
    }

    return result;
});

// 予約日時を持たせて確認画面へ遷移
const confirm = (confirmDate, confirmTime) => {
    navigateTo(`/confirm/${confirmDate}/${confirmTime}`);
};

// 初回実行
makeReservations();
</script>

<style scoped>
.reservation {
    background-color: #cce9fa;
    width: 100%;
    height: 90vh;
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

.table-scroll-wrapper {
    overflow: auto;
    width: 100%;
    height: 650px;
    margin-top: 80px;
}

.reservation-list {
    width: 90%;
    height: 80vh;
    margin: 0 auto;
    text-align: center;
    align-items: center;
    border-collapse: collapse;
    border: 1px solid #304654;
    color: #304654;
}

.fix-th {
    white-space: nowrap;
    background-color: #cce9fa;
    position: sticky;
    top: 0;
    left: 0;
}

.table-cell-btn {
    width: 100%;
    height: 100%;
    padding: 0;
    background-color: transparent;
    color: #304654;
    font-family: "Hiragino Kaku Gothic ProN";
    font-size: 16px;
    border: none;
    cursor: pointer;
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
