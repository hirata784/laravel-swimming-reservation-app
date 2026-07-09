<template>
    <div class="reservation">
        <div class="reservation-content">
            <h2 class="title">2026年7月</h2>
            <table class="reservation-list">
                <tbody>
                    <tr>
                        <th>受付時刻</th>
                        <th>1(水)</th>
                        <th>2(木)</th>
                        <th>3(金)</th>
                        <th>4(土)</th>
                        <th>5(日)</th>
                        <th>6(月)</th>
                        <th>7(火)</th>
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
                    <tr>
                        <th></th>
                        <th>1(水)</th>
                        <th>2(木)</th>
                        <th>3(金)</th>
                        <th>4(土)</th>
                        <th>5(日)</th>
                        <th>6(月)</th>
                        <th>7(火)</th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

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
