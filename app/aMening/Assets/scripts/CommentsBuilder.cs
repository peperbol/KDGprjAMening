﻿using UnityEngine;
using System.Collections;
using UnityEngine.UI;
using System.Linq;
using System.Threading;
using System.Globalization;
/// <summary>
/// Builds the content of the comment section
/// </summary>
public class CommentsBuilder : MonoBehaviour {

    public Transform commentContainter;
    public Transform commentPrefab;
    public Transform noCommentsPrefab;
    public void Start() {
        Thread.CurrentThread.CurrentCulture = new CultureInfo("nl-BE");
        SetComments(new Comment[0]);
    } 
    public void SetComments(Comment[] comments) {
        for (int i = 0; i < commentContainter.childCount; i++)
        {
            Destroy(commentContainter.GetChild(i).gameObject);
        }
        if (comments.Length <= 0) {

            Transform inst = Instantiate(noCommentsPrefab);
            inst.SetParent(commentContainter);
            inst.localPosition = Vector3.zero;
        }
        for (int i = 0; i < comments.Length; i++)
        {
            Transform inst = Instantiate(commentPrefab);
            inst.Find("body").GetComponent<Text>().text = comments[i].text;
            inst.GetComponentsInChildren<Text>().First(e=> e.gameObject.name == "date").text = comments[i].day;
            inst.GetComponentsInChildren<Text>().First(e => e.gameObject.name == "time").text = comments[i].time;
            inst.SetParent(commentContainter);
            inst.localPosition = Vector3.zero;
        }
    }
    
}
