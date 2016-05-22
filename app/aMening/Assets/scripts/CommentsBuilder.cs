using UnityEngine;
using System.Collections;
using UnityEngine.UI;
using System.Linq;
using System.Threading;
using System.Globalization;

public class CommentsBuilder : MonoBehaviour {

    public Transform CommentContainter;
    public Transform CommentPrefab;
    public void Start() {
        Thread.CurrentThread.CurrentCulture = new CultureInfo("nl-BE");
        SetComments(new Comment[0]);
    } 
    public void SetComments(Comment[] comments) {
        for (int i = 0; i < CommentContainter.childCount; i++)
        {
            Destroy(CommentContainter.GetChild(i).gameObject);
        }
        for (int i = 0; i < comments.Length; i++)
        {
            Transform inst = Instantiate(CommentPrefab);
            inst.Find("body").GetComponent<Text>().text = comments[i].text;
            inst.GetComponentsInChildren<Text>().First(e=> e.gameObject.name == "date").text = comments[i].timeStamp.ToShortDateString();
            inst.GetComponentsInChildren<Text>().First(e => e.gameObject.name == "time").text = comments[i].timeStamp.ToShortTimeString();
            inst.SetParent(CommentContainter);
            inst.localPosition = Vector3.zero;
        }
    }
    
}
