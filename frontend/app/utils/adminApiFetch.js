export const adminApiFetch = async (url, options = {}) => {
    // トークンを取得
    const { token } = useAdminAuth();

    try {
        return await $fetch(url, {
            // 呼び出し元から渡された設定（method, bodyなど）を展開
            ...options,
            headers: {
                Authorization: `Bearer ${token.value}`,
                // 呼び出し元でheadersが指定されていればそれもマージ
                // （未定義対策で || {} をつけている）
                ...(options.headers || {}),
            },
        });
    } catch (error) {
        // エラー
        throw error;
    }
};
