/**
 * Hubspotのフォーム送信
 *
 * @param {String} portalId ポータルID
 * @param {String} formId フォームID
 * @param {Array} fields フォームデータ
 * @param {Object} context 記事データ
 */
export async function sendHubspot(portalId, formId, fields, context) {
  const url = `https://api.hsforms.com/submissions/v3/integration/submit/${portalId}/${formId}`;
  await axios.post(url, { fields, context });
}
