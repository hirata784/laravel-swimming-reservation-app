<template>
    <div class="reservation">
        <div class="reservation-content">
            <h2 class="title">予約管理</h2>
            <div class="reservation-form">
                <div class="week-pagination">
                    <button class="week-btn">← 前の週</button>
                    <p>{{ weekStart }}~{{ weekFinish }}</p>
                    <button class="week-btn">次の週 →</button>
                </div>
                <div v-for="i in 7">
                    <div class="date-toggle">
                        <!-- トグル表示 -->
                        <button class="date" @click="toggle(i - 1)">
                            {{ formatDate(dates[i - 1]) }}({{ days[i - 1] }})
                            <span class="toggle">{{
                                isOpen[i - 1] === true ? "-" : "+"
                            }}</span>
                        </button>
                    </div>
                    <div v-for="j in 10" class="group">
                        <div v-if="isOpen[i - 1]" class="item-group">
                            <p class="time">
                                {{ (j + 8).toString().padStart(2, "0") }}:00
                            </p>
                            <p class="reservation-people">3/7人</p>
                            <button class="detail-btn" type="button">
                                詳細
                            </button>
                        </div>
                        <div v-if="isOpen[i - 1]" class="item-group">
                            <p class="time">
                                {{ (j + 8).toString().padStart(2, "0") }}:30
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
// クエリパラメータから年月日を受け取り格納(予定)
const test = "2026-09-21";
// 週の開始日
const dateStart = new Date(test);
// 週の最終日
const dateFinish = new Date(dateStart);
dateFinish.setDate(dateFinish.getDate() + 6);
// 月と日
const monthStart = (dateStart.getMonth() + 1).toString().padStart(2, "0");
const dayStart = dateStart.getDate().toString().padStart(2, "0");
const monthFinish = (dateFinish.getMonth() + 1).toString().padStart(2, "0");
const dayFinish = dateFinish.getDate().toString().padStart(2, "0");
// 表示用
const weekStart = `${monthStart}/${dayStart}`;
const weekFinish = `${monthFinish}/${dayFinish}`;
// 年月日
const dates = ref([]);
// 曜日
const days = ref([]);
// 曜日のテキスト
const weekday = ["日", "月", "火", "水", "木", "金", "土"];
// トグル開閉用フラグ
const isOpen = ref([]);

definePageMeta({
    layout: "admin", // 管理者用のヘッダーを表示
    middleware: "admin-auth", // 認証中のみアクセス可能にする
});

// 7日分用意する
for (let i = 0; i < 7; i++) {
    const d = new Date(dateStart);
    // 月末日に+1した場合、自動的に翌月の1日に進む
    d.setDate(dateStart.getDate() + i);
    // 年月日を取得(月日は頭を0で埋める(例：01日))
    const y = d.getFullYear();
    const m = String(d.getMonth() + 1).padStart(2, "0");
    const day = String(d.getDate()).padStart(2, "0");
    // 年月日を取得
    dates.value.push(`${y}-${m}-${day}`);
    // 曜日を取得
    days.value.push(weekday[d.getDay()]);
    // トグルのフラグを全て閉じるに設定
    isOpen.value.push(false);
}

// 月日フォーマット変更(例：09/21)
const formatDate = (dateString) => {
    // 空データ時のガード句（バグ防止）
    if (!dateString) return "";
    // 日付文字列をDateオブジェクトに変換
    const d = new Date(dateString);

    // 取得した日付から月・日を抽出して0埋め
    const mm = String(d.getMonth() + 1).padStart(2, "0");
    const dd = String(d.getDate()).padStart(2, "0");

    return `${mm}/${dd}`;
};

// クリックしたトグルを開く(開いているトグルの場合、閉じる)
const toggle = (i) => {
    if (!isOpen.value[i]) {
        // 全てfalseに変更
        isOpen.value.fill(false);
    }
    // クリックされた日付だけ開く
    isOpen.value[i] = !isOpen.value[i];
};
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

.date-toggle {
    display: flex;
    flex-direction: row;
}

.date {
    font-size: 20px;
    font-weight: bold;
    color: #304654;
    text-align: left;
    margin-top: 20px;
    width: 100%;
    border: none;
    background-color: #eef9ff;
    cursor: pointer;
}

.date:hover {
    background-color: #e1f4fd;
}

.toggle {
    margin-left: 10px;
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
