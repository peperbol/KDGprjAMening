using UnityEngine;
using System.Collections;
using System.Collections.Generic;

public class AnswerSender : MonoBehaviour {
    IEnumerator SendToServer (bool isLeft, Question q) {
        
        var form = new WWWForm();
        form.AddField("age", 0);
        form.AddField("gender_id", 1);
        form.AddField("answer", System.Convert.ToInt32(!isLeft));
        form.AddField("question_id", int.Parse(q.id));
        
        var www = new WWW(PathsConfig.AnswerUrl,form);
        while (!www.isDone)
        {
            yield return null;
        }
        Debug.Log(PathsConfig.AnswerUrl);
        Debug.Log("sent");
        Debug.Log(www.error);
        Debug.Log(www.text);
        

    }
    public void SendAnswer(bool isLeft, Question q)
    {
        StartCoroutine(SendToServer(isLeft, q));
    }
}
