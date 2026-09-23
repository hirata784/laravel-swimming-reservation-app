export const useAdminAuth = () => {
    const cookieToken = useCookie("token");
    const token = useState("token", () => cookieToken.value || null);
    const user = useState("user", () => null);

    watch(token, (newVal) => {
        cookieToken.value = newVal;
    });

    // tokenがある場合、ユーザー名を取得する
    const fetchUser = async () => {
        if (!token.value) return;
        try {
            const res = await adminApiFetch("http://localhost/api/admins/me");
            user.value = res;
        } catch (error) {
            // エラー表示
            console.error("予期せぬエラーが発生しました：", error);
            alert(`予期せぬエラーが発生しました： ${error}`);
        }
    };

    // ログアウト
    const logout = async () => {
        try {
            // サーバー側ログアウト
            await adminApiFetch("http://localhost/api/admins/logout", {
                method: "POST",
                headers: {
                    // JWT等を使用している場合はここでAuthorizationヘッダーを渡す
                    Authorization: `Bearer ${token.value}`,
                },
            });

            // クライアント側ログアウト
            token.value = null;
            // ユーザーの情報を削除
            user.value = null;
            // 管理者ログイン画面へ遷移する
            return navigateTo("/admin/login");
        } catch (error) {
            // エラー表示
            console.error("予期せぬエラーが発生しました：", error);
            alert(`予期せぬエラーが発生しました： ${error}`);
        }
    };

    return {
        user,
        token,
        fetchUser,
        logout,
    };
};
